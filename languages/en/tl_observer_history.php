<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrLang = &$GLOBALS['TL_LANG']['tl_observer_history'];

/**
 * Fields
 */
$arrLang['tstamp'] = array('Revision date', '');
$arrLang['eid']    = array('Entity ID', 'The id of the entity, the run on.');
$arrLang['table']  = array('Entity table', 'The table name of the entity');
$arrLang['type']   = array('Type', 'The observer type.');
$arrLang['action'] = array('Action', 'The action type.');
$arrLang['state']  = array('State', 'The state of the run action.');
$arrLang['state']  = array('Last run', 'The date of last run.');