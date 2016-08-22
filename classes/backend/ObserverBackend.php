<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Observer\Backend;

use HeimrichHannot\Haste\Util\StringUtil;
use HeimrichHannot\Observer\ObserverConfig;
use HeimrichHannot\Observer\ObserverLog;
use HeimrichHannot\Observer\ObserverLogModel;
use HeimrichHannot\Observer\ObserverManager;
use HeimrichHannot\Observer\ObserverModel;

class ObserverBackend extends \Backend
{

	public function modifyDc(\DataContainer $dc)
	{
		if(($objModel = ObserverModel::findByPk($dc->id)) === null || !$objModel->subject)
		{
			return;
		}


		if(($objSubject = ObserverManager::findSubjectByModel($objModel)) === null)
		{
			return;
		}


		if(($objObserver = ObserverManager::findObserverBySubject($objSubject)) === null)
		{
			return;
		}

		$arrDca = &$GLOBALS['TL_DCA']['tl_observer'];
		$arrPalettes = $objObserver::getPalettes($dc);

		if(!is_array($arrPalettes) || !is_array($arrDca['palettes']))
		{
			return;
		}

		foreach ($arrPalettes as $strKey => $strInvocation)
		{
			// skip if observer does not exist
			if(!isset($arrDca['palettes'][$strKey]))
			{
				continue;
			}

			if(!StringUtil::startsWith($strInvocation, '{'))
			{
				$strInvocation = ',' . ltrim($strInvocation, ',;');
			}


			$arrDca['palettes'][$strKey] = str_replace(',observer', ',observer' .  $strInvocation, $arrDca['palettes'][$strKey]);
		}
	}

	/**
	 * Modify the backend group title and add the action
	 * @param                $group
	 * @param                $mode
	 * @param                $field
	 * @param                $row
	 * @param \DataContainer $dc
	 *
	 * @return string
	 */
	public function getGroupTitle($group, $mode, $field, $row, \DataContainer $dc)
	{
		$strSubject = $GLOBALS['TL_LANG']['OBSERVER_SUBJECT'][$row['subject']] ?: $row['subject'];
		$strObserver = $GLOBALS['TL_LANG']['OBSERVER_OBSERVER'][$row['observer']] ?: $row['observer'];
		return '<span class="tl_blue">' . $strSubject . '</span> &raquo; ' . $strObserver;
	}
	
	/**
	 * Colorize the entries depending on their latest invocation
	 *
	 * @param array  $arrRow
	 * @param string $label
	 *
	 * @return string
	 */
	public function colorize($arrRow, $label)
	{
		$objLatestLog = ObserverLogModel::findLatestByTypeAndPid(ObserverLog::TYPE_INVOKE, $arrRow['id']);
		
		if($objLatestLog !== null)
		{
			$strClass = ObserverLog::getColorClassFromAction($objLatestLog->action);
		}
		
		$strClass = ($strClass ? ' class="' . $strClass . '"' : '');
		
		return '<div class="ellipsis">' . $arrRow['title'] . ' <span style="padding-left:3px"' . $strClass . '>[' . \Date::parse(\Config::get('datimFormat'), $objLatestLog->tstamp) . ']</span> [' . $arrRow['priority'] .']</div>';
	}
	
	/**
	 * On create callback
	 * @param                $strTable
	 * @param                $insertID
	 * @param                $arrSet
	 * @param \DataContainer $dc
	 */
	public function onCreate($strTable, $insertID, $arrSet, \DataContainer $dc)
	{
		if(($objModel = ObserverModel::findByPk($insertID)) === null)
		{
			return;
		}
		
		if(($uuid = ObserverConfig::getDefaultAttachmentsDir()) !== null && \Validator::isUuid($uuid))
		{
			$objModel->attachmentsDir = \StringUtil::uuidToBin($uuid);
		}
		
		$objModel->save();
	}
	
	/**
	 * Set default attachment dir
	 * @param                $varValue
	 * @param \DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setAttachmentsDir($varValue, \DataContainer $dc)
	{
		if ($varValue == '')
		{
			return ObserverConfig::getDefaultAttachmentsDir();
		}
		
		return $varValue;
	}
	
	/**
	 * Get all subjects as array
	 * @param \DataContainer $dc
	 *
	 * @return array
	 */
	public function getSubjects(\DataContainer $dc)
	{
		return ObserverConfig::getSubjects();
	}
	
	/**
	 * Get all observer within selected subject
	 * @param \DataContainer $dc
	 *
	 * @return array
	 */
	public function getObservers(\DataContainer $dc)
	{
		$objModel = ObserverModel::findByPk($dc->id);

		if($objModel === null)
		{
			return array();
		}

		return ObserverConfig::getObserverByModel($objModel);
	}
}