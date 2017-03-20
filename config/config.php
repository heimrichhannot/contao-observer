<?php

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['observer'] = [
    'tables' => ['tl_observer', 'tl_observer_log', 'tl_observer_history'],
    'icon'   => 'system/modules/observer/assets/img/icon-observer.png',
];

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
    [
		\HeimrichHannot\Observer\ObserverConfig::OBSERVER_SUBJECT_MAIL => 'HeimrichHannot\Observer\MailSubject',
    ]
);

/**
 * Observers
 */
array_insert(
	$GLOBALS['OBSERVER']['OBSERVERS'],
    0,
    []
);

/**
 * Notification Center Notification Types
 */
$arrTaskNotification                 = \HeimrichHannot\Haste\Dca\Notification::getNewNotificationTypeArray(true);
$arrTaskNotification                 = \HeimrichHannot\Haste\Dca\Notification::addFormHybridStyleEntityTokens('observer_entity', $arrTaskNotification);
$arrTaskNotification                 = \HeimrichHannot\Haste\Dca\Notification::addFormHybridStyleEntityTokens('observer_member', $arrTaskNotification);
$arrTaskNotification['email_text'][] = 'salutation_member';
$arrTaskNotification['email_html'][] = 'salutation_member';

\HeimrichHannot\Haste\Dca\Notification::activateType(
	HeimrichHannot\Observer\ObserverNotification::NOTIFICATION_TYPE_OBSERVER,
	HeimrichHannot\Observer\ObserverNotification::NOTIFICATION_TYPE_OBSERVER_NOTIFICATION,
	$arrTaskNotification
);


/**
 * Observer manager
 */
$GLOBALS['OBSERVER']['MANAGER'] = new \HeimrichHannot\Observer\ObserverManager();

/**
 * Cron jobs
 */
array_insert($GLOBALS['TL_CRON']['minutely'], 0, [['HeimrichHannot\Observer\ObserverManager', 'run']]);