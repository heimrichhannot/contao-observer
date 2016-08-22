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


class ObserverLogModel extends \Model
{
	protected static $strTable = 'tl_observer_log';
	
	/**
	 * Find latest log entry by type and pid
	 *
	 * @param string $strType    An log type
	 * @param int    $intId      An observer id
	 * @param array  $arrOptions An optional options array
	 *
	 * @return \ObserverLogModel|null The model or null if there are no latest log entries
	 */
	public static function findLatestByTypeAndPid($strType, $intId, array $arrOptions = array())
	{
		$t          = static::$strTable;
		$arrColumns = array("$t.type = ? AND $t.pid = ?");
		
		$arrOptions['order'] = 'tstamp DESC';
		
		return static::findOneBy($arrColumns, array($strType, $intId), $arrOptions);
	}
}