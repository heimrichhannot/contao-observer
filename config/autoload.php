<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Observer
	'HeimrichHannot\Observer\Subject'                 => 'system/modules/observer/observer/subjects/Subject.php',
	'HeimrichHannot\Observer\MailSubject'             => 'system/modules/observer/observer/subjects/MailSubject.php',
	'HeimrichHannot\Observer\NotificationObserver'    => 'system/modules/observer/observer/observers/NotificationObserver.php',
	'HeimrichHannot\Observer\Observer'                => 'system/modules/observer/observer/observers/Observer.php',

	// Classes
	'HeimrichHannot\Observer\ObserverNotification'    => 'system/modules/observer/classes/ObserverNotification.php',
	'HeimrichHannot\Observer\ObserverManager'         => 'system/modules/observer/classes/ObserverManager.php',
	'HeimrichHannot\Observer\Backend\Observer'        => 'system/modules/observer/classes/backend/Observer.php',
	'HeimrichHannot\Observer\Backend\ObserverHistory' => 'system/modules/observer/classes/backend/ObserverHistory.php',
	'HeimrichHannot\Observer\Backend\ObserverLog'     => 'system/modules/observer/classes/backend/ObserverLog.php',
	'HeimrichHannot\Observer\ObserverConfig'          => 'system/modules/observer/classes/ObserverConfig.php',
	'HeimrichHannot\Observer\ObserverLog'             => 'system/modules/observer/classes/ObserverLog.php',

	// Models
	'HeimrichHannot\Observer\ObserverLogModel'        => 'system/modules/observer/models/ObserverLogModel.php',
	'HeimrichHannot\Observer\ObserverModel'           => 'system/modules/observer/models/ObserverModel.php',
	'HeimrichHannot\Observer\ObserverHistoryModel'    => 'system/modules/observer/models/ObserverHistoryModel.php',
));
