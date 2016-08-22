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


use HeimrichHannot\Observer\ObserverLog;

class ObserverHistoryBackend extends \Backend
{
	
	/**
	 * Colorize the history entries depending on their state
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function colorize($arrRow)
	{
		$strClass = ObserverLog::getColorClassFromAction($arrRow['state']);
		
		$strClass = ($strClass ? ' ' : '') . $strClass;
		
		return '<div class="ellipsis ' . $strClass . '"><span style="padding-right:3px">[' . \Date::parse(\Config::get('datimFormat'), $arrRow['tstamp']) . ']</span>' . $arrRow['state'] . '</div>';
	}
}