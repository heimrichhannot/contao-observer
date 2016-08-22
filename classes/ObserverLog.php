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


class ObserverLog
{
	const TYPE_INVOKE = 'INVOKE';
	
	const SUCCESS = 'SUCCESS';
	const ERROR   = 'ERROR';
	const INFO    = 'INFO';
	
	/**
	 * Add a log entry to the database
	 *
	 * @param int    $intId       The observer id
	 * @param string $strText     The log message
	 * @param string $strFunction The function name
	 * @param string $strType     The type name
	 * @param string $strCategory The category name
	 * @param string $tstamp      A valid unix timestamp
	 */
	public static function add($intId, $strText, $strFunction, $strType = '', $strCategory = ObserverLog::INFO, $tstamp = null)
	{
		if ($tstamp === null)
		{
			$tstamp = time();
		}
		
		$objModel         = new ObserverLogModel();
		$objModel->pid    = $intId;
		$objModel->tstamp = $tstamp;
		$objModel->action = $strCategory;
		$objModel->text   = $strText;
		$objModel->func   = $strFunction;
		$objModel->type   = $strType;
		$objModel->save();
	}
	
	/**
	 * Return contao backend color class for given log action
	 *
	 * @param $strAction
	 *
	 * @return string
	 */
	public static function getColorClassFromAction($strAction)
	{
		switch ($strAction)
		{
			case static::SUCCESS:
				return 'tl_green';
			case static::ERROR:
				return 'tl_red';
			case static::INFO:
				return 'tl_blue';
		}
		
		return '';
	}
}