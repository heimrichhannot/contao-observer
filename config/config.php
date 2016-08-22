<?php

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['observer'] = array(
	'tables' => array('tl_observer', 'tl_observer_log', 'tl_observer_history'),
	'icon'   => 'system/modules/observer/assets/img/icon-observer.png',
);

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_observer']         = 'HeimrichHannot\Observer\ObserverModel';
$GLOBALS['TL_MODELS']['tl_observer_history'] = 'HeimrichHannot\Observer\ObserverHistoryModel';
$GLOBALS['TL_MODELS']['tl_observer_log']     = 'HeimrichHannot\Observer\ObserverLogModel';

/**
 * Observer subjects
 */
array_insert(
	$GLOBALS['OBSERVER']['SUBJECTS'],
	0,
	array(
		\HeimrichHannot\Observer\ObserverConfig::OBSERVER_SUBJECT_MAIl => 'HeimrichHannot\Observer\MailSubject',
	)
);

/**
 * Observers
 */
array_insert(
	$GLOBALS['OBSERVER']['OBSERVERS'],
	0,
	array()
);


/**
 * Observer manager
 */
$GLOBALS['OBSERVER']['MANAGER'] = new \HeimrichHannot\Observer\ObserverManager();

/**
 * Cron jobs
 */
array_insert($GLOBALS['TL_CRON']['minutely'], 0, array(array('HeimrichHannot\Observer\ObserverManager', 'run')));