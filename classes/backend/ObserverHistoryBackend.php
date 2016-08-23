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
	 * List the history entries
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listItem($arrRow)
	{
		$state = $GLOBALS['TL_LANG']['OBSERVER_STATES'][$arrRow['state']] ?: $arrRow['state'];

		return '<div class="ellipsis"><span style="padding-right:3px">[' . \Date::parse(\Config::get('datimFormat'), $arrRow['tstamp']) . ']</span>' . htmlspecialchars($arrRow['entityId']) . ' (' . $state . ')</div>';
	}
}