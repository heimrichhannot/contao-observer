<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
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
	// Models
	'HeimrichHannot\Observer\ObserverModel'                  => 'system/modules/observer/models/ObserverModel.php',
	'HeimrichHannot\Observer\ObserverLogModel'               => 'system/modules/observer/models/ObserverLogModel.php',
	'HeimrichHannot\Observer\ObserverHistoryModel'           => 'system/modules/observer/models/ObserverHistoryModel.php',

	// Observer
	'HeimrichHannot\Observer\MailSubject'                    => 'system/modules/observer/observer/subjects/MailSubject.php',
	'HeimrichHannot\Observer\Subject'                        => 'system/modules/observer/observer/subjects/Subject.php',
	'HeimrichHannot\Observer\Observer'                       => 'system/modules/observer/observer/observers/Observer.php',
	'HeimrichHannot\Observer\NotificationObserver'           => 'system/modules/observer/observer/observers/NotificationObserver.php',

	// Classes
	'HeimrichHannot\Observer\ObserverManager'                => 'system/modules/observer/classes/ObserverManager.php',
	'HeimrichHannot\Observer\ObserverLog'                    => 'system/modules/observer/classes/ObserverLog.php',
	'HeimrichHannot\Observer\Backend\ObserverLogBackend'     => 'system/modules/observer/classes/backend/ObserverLogBackend.php',
	'HeimrichHannot\Observer\Backend\ObserverHistoryBackend' => 'system/modules/observer/classes/backend/ObserverHistoryBackend.php',
	'HeimrichHannot\Observer\Backend\ObserverBackend'        => 'system/modules/observer/classes/backend/ObserverBackend.php',
	'HeimrichHannot\Observer\ObserverConfig'                 => 'system/modules/observer/classes/ObserverConfig.php',
	'HeimrichHannot\Observer\ObserverNotification'           => 'system/modules/observer/classes/ObserverNotification.php',
));
