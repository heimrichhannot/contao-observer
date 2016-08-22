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


class ObserverConfig
{
	const OBSERVER_SUBJECT_MAIl = 'mail';
	
	const OBSERVER_DIRECTORY_ATTACHMENT = 'files/observer/attachments';
	
	const OBSERVER_CRON_MINUTELY = 'minutely';
	const OBSERVER_CRON_HOURLY   = 'hourly';
	const OBSERVER_CRON_DAILY    = 'daily';
	const OBSERVER_CRON_WEEKLY   = 'weekly';
	const OBSERVER_CRON_MONTHLY  = 'monthly';
	const OBSERVER_CRON_YEARLY   = 'yearly';

	/**
	 * Get all observer by given observer model
	 *
	 * @param ObserverModel $objModel
	 *
	 * @return  array
	 */
	public static function getObserverByModel(ObserverModel $objModel)
	{
		$arrOptions = array();

		if(($objObserver = ObserverManager::findSubjectByModel($objModel)) === null)
		{
			return $arrOptions;
		}

		foreach(static::getObservers() as $strAction)
		{
			if(($objAction = ObserverManager::findObserverBySubject($objObserver, $strAction)) === null)
			{
				continue;
			}

			$arrPalettes = $objAction::getPalettes();

			if(!is_array($arrPalettes) || !isset($arrPalettes[$objModel->subject]))
			{
				return;
			}

			$arrOptions[] = $strAction;
		}

		return $arrOptions;
	}

	/**
	 * Get all observer as array
	 * @return array
	 */
	public static function getObservers()
	{
		return array_keys($GLOBALS['OBSERVER']['OBSERVERS']);
	}
	
	/**
	 * Get all observer types as array
	 *
	 * @return array
	 */
	public static function getSubjects()
	{
		return array_keys($GLOBALS['OBSERVER']['SUBJECTS']);
	}


	/**
	 * Return the subject class for a given type
	 *
	 * @param string $strSubject The subject name
	 *
	 * @return string | null The class name or null if not exists
	 */
	public static function getSubjectClass($strSubject)
	{
		if (!is_array($GLOBALS['OBSERVER']['SUBJECTS']))
		{
			return null;
		}
		
		$strClass = $GLOBALS['OBSERVER']['SUBJECTS'][$strSubject];
		
		if (!class_exists($strClass))
		{
			return null;
		}
		
		return $strClass;
	}
	
	/**
	 * Return the observer class for a given type
	 *
	 * @param string $strObserver The action name
	 *
	 * @return string | null The class name or null if not exists
	 */
	public static function getObserverClass($strObserver)
	{
		if (!is_array($GLOBALS['OBSERVER']['OBSERVERS']))
		{
			return null;
		}
		
		$strClass = $GLOBALS['OBSERVER']['OBSERVERS'][$strObserver];
		
		if (!class_exists($strClass))
		{
			return null;
		}
		
		return $strClass;
	}
	
	/**
	 * Get the default attachment directory value
	 *
	 * @param bool $blnReturnPath Return the path to the directory instead of the uuid
	 *
	 * @return null|string The uuid string, or path if $blnReturnPath is true, otherwise null
	 */
	public static function getDefaultAttachmentsDir($blnReturnPath = false)
	{
		$objFolder = new \Folder(static::OBSERVER_DIRECTORY_ATTACHMENT);
		
		if ($blnReturnPath)
		{
			return $objFolder->path;
		}
		
		if (\Validator::isUuid($objFolder->getModel()->uuid))
		{
			return \StringUtil::binToUuid($objFolder->getModel()->uuid);
		}
		
		return null;
	}
}