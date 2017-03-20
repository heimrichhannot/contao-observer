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


class ObserverHistoryModel extends \Model
{
	protected static $strTable = 'tl_observer_history';

	/**
	 * Find latest log entry by type and pid
	 *
	 * @param int   $pid        The observer model id
	 * @param mixed $varId      An entity id
	 * @param array $arrStates  An observer history states
	 * @param array $arrOptions An optional options array
	 *
	 * @return \ObserverHistoryModel|null The model or null if there are no history entries
	 */
	public static function findByParentAndEntityIdAndState($pid, $varId, array $arrStates = [], array $arrOptions = [])
	{
		$t          = static::$strTable;
		$arrColumns = ["$t.pid = ? AND $t.entityId = ?"];

		$arrColumns[] = \Database::getInstance()->findInSet('state', $arrStates);

		return static::findBy($arrColumns, [$pid, $varId], $arrOptions);
	}


	public static function hasRun($pid, $varId, array $arrStates = [Observer::STATE_SUCCESS], array $arrOptions = [])
	{
		return static::findByParentAndEntityIdAndState($pid, $varId, $arrStates, $arrOptions) !== null;
	}
}