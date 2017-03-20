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
$GLOBALS['TL_LANG']['OBSERVER_SUBJECT'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_SUBJECT_MAIL] = 'Mailbox';

/**
 * Imap Options
 */
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_READONLY]   = '<strong>OP_READONLY</strong> - Mailbox mit Nur-Lese-Zugriff öffnen';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_ANONYMOUS]  = '<strong>OP_ANONYMOUS</strong> - Keine .newsrc für News anlegen oder ändern (nur NNTP)';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_HALFOPEN]   = '<strong>OP_HALFOPEN</strong> - Für IMAP- und NNTP-Namen eine Verbindung (aber keine Mailbox) öffnen.';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][CL_EXPUNGE]    = '<strong>CL_EXPUNGE</strong> - Mailbox automatisch beim Schließen der Verbindung leeren (siehe auch imap_delete() und imap_expunge())';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_DEBUG]      = '<strong>OP_DEBUG</strong> - Protokoll-Negotiations protokollieren';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SHORTCACHE] = '<strong>OP_SHORTCACHE</strong> - Kurzes (elt-only) caching';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SILENT]     = '<strong>OP_SILENT</strong> - Events nicht "nach oben" weiterreichen (internal use)';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_PROTOTYPE]  = '<strong>OP_PROTOTYPE</strong> - Driver-Prototype zurückgeben';
$GLOBALS['TL_LANG']['MSC']['imapOptions'][OP_SECURE]     = '<strong>OP_SECURE</strong> - Unsichere Verbindungen ablehnen';

/**
 * Cron intervals
 */
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_MINUTELY] = 'Minütlich';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_HOURLY]   = 'Stündlich';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_DAILY]    = 'Täglich';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_WEEKLY]   = 'Wöchentlich';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_MONTHLY]  = 'Monatlich';
$GLOBALS['TL_LANG']['MSC']['cronInterval'][\HeimrichHannot\Observer\ObserverConfig::OBSERVER_CRON_YEARLY]   = 'Jährlich';

/**
 * Observer states
 */
$GLOBALS['TL_LANG']['OBSERVER_STATES']['success'] = 'Erfolg';
$GLOBALS['TL_LANG']['OBSERVER_STATES']['error'] = 'Fehler';
$GLOBALS['TL_LANG']['OBSERVER_STATES']['runonce'] = 'Runonce';

/**
 * Misc
 */
$GLOBALS['TL_LANG']['MSC']['observer']['observer'] = 'Observer';
$GLOBALS['TL_LANG']['MSC']['observer']['subject'] = 'Subjekt';