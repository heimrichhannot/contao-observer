<?php

/**
 * Use as follows:
 * $ queue -s <queue_gateway_id> -n <number of messages to be sent>
 *
 * E.g. to send 15 messages of source queue gateway ID 2, do this:
 *
 * $ queue -s 2 -n 15
 */

define('TL_MODE', 'FE');

if (file_exists(__DIR__ . '/../../../initialize.php')) {
    // Regular way
    require_once(__DIR__ . '/../../../initialize.php');
} elseif (file_exists(__DIR__.'/../../../../system/initialize.php'))
{
    define('TL_SCRIPT', 'contao/install.php');
    //Contao 4 location
    require_once (__DIR__.'/../../../../system/initialize.php');
} else  {
    // Try composer location (see #77)
    require_once(__DIR__ . '/../../../../../system/initialize.php');
}

$manager = $GLOBALS['OBSERVER']['MANAGER'];
$manager->run();