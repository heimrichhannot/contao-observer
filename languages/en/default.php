<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


/**
 * Observer Types
 */
$GLOBALS['TL_LANG']['OBSERVER_SUBJECT']['mail'] = 'Mailbox';

/**
 * Imap Options
 */
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_READONLY]   = '<strong>OP_READONLY</strong> - Open mailbox read-only';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_ANONYMOUS]  = '<strong>OP_ANONYMOUS</strong> - Don\'t use or update a .newsrc for news (NNTP only)';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_HALFOPEN]   = '<strong>OP_HALFOPEN</strong> - For IMAP and NNTP names, open a connection but don\'t open a mailbox.';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][CL_EXPUNGE]    = '<strong>CL_EXPUNGE</strong> - Expunge mailbox automatically upon mailbox close (see also imap_delete() and imap_expunge())';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_DEBUG]      = '<strong>OP_DEBUG</strong> - Debug protocol negotiations';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SHORTCACHE] = '<strong>OP_SHORTCACHE</strong> - Short (elt-only) caching';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SILENT]     = '<strong>OP_SILENT</strong> - Don\'t pass up events (internal use)';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_PROTOTYPE]  = '<strong>OP_PROTOTYPE</strong> - Return driver prototype';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SECURE]     = '<strong>OP_SECURE</strong> - Don\'t do non-secure authentication';

/**
 * Cron intervals
 */
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_MINUTELY] = 'Minutely';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_HOURLY]   = 'Hourly';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_DAILY]    = 'Daily';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_WEEKLY]   = 'Weekly';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_MONTHLY]  = 'Monthly';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_YEARLY]   = 'Yearly';

/**
 * Observer states
 */
$GLOBALS['TL_LANG']['OBSERVER_STATES']['success'] = 'Success';
$GLOBALS['TL_LANG']['OBSERVER_STATES']['error'] = 'Error';
$GLOBALS['TL_LANG']['OBSERVER_STATES']['runonce'] = 'Run once';
