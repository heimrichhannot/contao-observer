<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Observer;


use Cron\CronExpression;
use HeimrichHannot\Haste\DateUtil;
use PhpImap\Exception;

class ObserverManager
{

	public function run()
	{
		$arrSubjects = ObserverConfig::getSubjects();

		if (!is_array($arrSubjects))
		{
			return;
		}

		$objModels = ObserverModel::findPublishedBySubjects($arrSubjects);

		if ($objModels === null)
		{
			return;
		}

		while ($objModels->next())
		{
			$strSuccessMessage = 'Observer invocation success';
			$strErrorMessage   = 'Observer invocation error';
			$doProceed         = true;
			$strFunction       = __CLASS__ . ':' . __METHOD__ . '()';
			$time              = time();

			if (!static::checkUpdate($objModels->current(), $time))
			{
				continue;
			}

			if (($objSubject = static::findSubjectByModel($objModels->current())) === null)
			{
				$strErrorMessage = 'Subject for:' . $objModels->subject . ' not found.';
				$doProceed       = false;
			}

			if ($doProceed && !$objSubject instanceof Subject)
			{
				$strErrorMessage = get_class($objSubject) . ' must be instanceof HeimrichHannot\Observer\Subject.';
				$doProceed       = false;
			}


			if ($doProceed && ($objObserver = static::findObserverBySubject($objSubject)) === null)
			{
				$doProceed = false;

				if ($objModels->action)
				{
					$strErrorMessage = 'Observer :' . $objModels->action . ' not found.';
				} else
				{
					$strErrorMessage = 'No observer given, please provide a valid observer.';
				}
			}

			if ($doProceed && !$objObserver instanceof Observer)
			{
				$strErrorMessage = get_class($objObserver) . ' must be instanceof HeimrichHannot\Observer\Observer.';
				$doProceed       = false;
			}

			if ($doProceed)
			{
				$objSubject->attach($objObserver);

				try
				{
					$objSubject->notify();
				}
				catch (\Exception $e)
				{
					$strErrorMessage = $strErrorMessage . ': ' . $e->getMessage();
					$strFunction     = get_class($objSubject) . ':' . 'notify()';
					$doProceed       = false;
				}

				$objSubject->detach($objObserver);
			}


			$objModels->invoked      = $time;
			$objModels->invokedState = $doProceed ? ObserverLog::SUCCESS : ObserverLog::ERROR;
			$objModels->save();

			ObserverLog::add(
				$objModels->id,
				$doProceed ? $strSuccessMessage : $strErrorMessage,
				$strFunction,
				ObserverLog::TYPE_INVOKE,
				$doProceed ? ObserverLog::SUCCESS : ObserverLog::ERROR,
				$time
			);
		}
	}


	/**
	 * @param ObserverModel $objModel
	 * @param string        $strType
	 *
	 * @return Observer|null|false Return the Subject object or null if not existing
	 */
	public static function findSubjectByModel(ObserverModel $objModel, $strType = null)
	{
		if ($strType === null)
		{
			$strType = $objModel->subject;
		}

		if (($strClass = ObserverConfig::getSubjectClass($strType)) === null)
		{
			return null;
		}

		return new $strClass($objModel);
	}

	/**
	 * @param Subject $objSubject
	 * @param string  $strObserver
	 *
	 * @return Action|null|false Return the Observer object or null if not existing
	 */
	public static function findObserverBySubject(Subject $objSubject, $strObserver = null)
	{
		if ($strObserver === null)
		{
			$strObserver = $objSubject->getModel()->observer;
		}

		if (($strClass = ObserverConfig::getObserverClass($strObserver)) === null)
		{
			return null;
		}

		return new $strClass($objSubject);
	}

	public static function checkUpdate(ObserverModel $objModel, $time)
	{
		// cron expression does is not affected by last invoke date
		if ($objModel->useCronExpression && $objModel->cronExpression)
		{
			try
			{
				$cron = CronExpression::factory($objModel->cronExpression);

				return $cron->isDue();
			} catch (\Exception $e)
			{
				ObserverLog::add(
					$objModel->id,
					'Cron Expression failure:' . $e->getMessage(),
					__CLASS__ . ':' . 'checkUpdate()',
					ObserverLog::ERROR,
					$time
				);

				return false;
			}
		}

		// did never run before
		if (!$objModel->invoke)
		{
			return true;
		}

		$timeDiff = DateUtil::getTimeDiff($objModel->invoke);

		switch ($objModel->cronInterval)
		{
			case ObserverConfig::OBSERVER_CRON_MINUTELY:
				return $timeDiff >= 60;
			case ObserverConfig::OBSERVER_CRON_HOURLY:
				return $timeDiff >= 3600;
			case ObserverConfig::OBSERVER_CRON_DAILY:
				return $timeDiff >= 86400;
			case ObserverConfig::OBSERVER_CRON_WEEKLY:
				return $timeDiff >= 604800;
			case ObserverConfig::OBSERVER_CRON_MONTHLY:
				return $timeDiff >= 2592000; // 30 days
			case ObserverConfig::OBSERVER_CRON_YEARLY:
				return $timeDiff >= 31557600; // 326.25 days
		}

		return true;
	}
}