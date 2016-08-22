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
			$strCategory       = '';
			$strSuccessMessage = 'Observer invocation success';
			$strErrorMessage   = 'Observer invocation error';
			$time              = time();

			if (!static::checkUpdate($objModels->current(), $time))
			{
				continue;
			}

			if (($objSubject = static::findSubjectByModel($objModels->current())) === null)
			{
				ObserverLog::add(
					$objModels->id,
					'Subject for:' . $objModels->subject . ' not found.',
					__CLASS__ . ':' . __METHOD__ . '()',
					'',
					ObserverLog::INFO
				);
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage,
					__CLASS__ . ':' . __METHOD__ . '()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}

			if (!$objSubject instanceof Subject)
			{
				$strCategory = ObserverLog::ERROR;
				ObserverLog::add(
					$objModels->id,
					get_class($objSubject) . ' must be instanceof HeimrichHannot\Observer\Subject.',
					__CLASS__ . ':' . __METHOD__ . '()',
					'',
					ObserverLog::INFO
				);
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage,
					__CLASS__ . ':' . __METHOD__ . '()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}


			$objModels->invoked = $time;
			$objModels->save();

			try
			{
				$strCategory = $objSubject->notify() ? ObserverLog::SUCCESS : ObserverLog::ERROR;
			} catch (\Exception $e)
			{
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage . ': ' . $e->getMessage(),
					get_class($objSubject) . ':' . 'notify()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}

			// continue on error
			if ($strCategory == ObserverLog::ERROR)
			{
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage,
					get_class($objSubject) . ':' . 'notify()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}


			if (($objObserver = static::findObserverBySubject($objSubject)) === null)
			{
				if ($objModels->action)
				{
					ObserverLog::add(
						$objModels->id,
						'Observer :' . $objModels->action . ' not found.',
						__CLASS__ . ':' . __METHOD__ . '()',
						'',
						ObserverLog::INFO
					);
				} else
				{
					ObserverLog::add(
						$objModels->id,
						'No observer given, please provide a valid observer.',
						__CLASS__ . ':' . __METHOD__ . '()',
						'',
						ObserverLog::INFO
					);
				}

				ObserverLog::add($objModels->id, $strErrorMessage, __CLASS__ . ':' . __METHOD__ . '()', ObserverLog::TYPE_INVOKE, '', $time);
				continue;
			}

			if (!$objObserver instanceof Observer)
			{
				ObserverLog::add(
					$objModels->id,
					get_class($objObserver) . ' must be instanceof HeimrichHannot\Observer\Observer.',
					__CLASS__ . ':' . __METHOD__ . '()',
					'',
					ObserverLog::INFO
				);
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage,
					__CLASS__ . ':' . __METHOD__ . '()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}

			try
			{
				$objSubject->attach($objObserver);
				$strCategory = $objObserver->update($objSubject) ? ObserverLog::SUCCESS : ObserverLog::ERROR;
			} catch (\Exception $e)
			{
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage . ': ' . $e->getMessage(),
					get_class($objObserver) . ':' . 'update()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}

			// continue on error
			if ($strCategory == ObserverLog::ERROR)
			{
				ObserverLog::add(
					$objModels->id,
					$strErrorMessage,
					get_class($objObserver) . ':' . 'update()',
					ObserverLog::TYPE_INVOKE,
					ObserverLog::ERROR,
					$time
				);
				continue;
			}

			ObserverLog::add(
				$objModels->id,
				$strSuccessMessage,
				get_class($objObserver) . ':' . 'update()',
				ObserverLog::TYPE_INVOKE,
				ObserverLog::SUCCESS,
				$time
			);

			$objSubject->detach($objObserver);
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
	 * @param string   $strObserver
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