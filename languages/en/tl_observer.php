<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_observer'];

/**
 * Fields
 */
$arrLang['title']               = array('Title', 'Please enter a title.');
$arrLang['subject']             = array('Subject', 'Please select a subject.');
$arrLang['imapPath']            = array('IMAP Path', 'The path to the IMAP Mailbox (e.g. {imap.gmail.com:993/imap/ssl}INBOX).');
$arrLang['imapLogin']           = array('IMAP Login', 'The login/username for the IMAP Mailbox (e.g. some@gmail.com).');
$arrLang['imapPassword']        = array('IMAP Password', 'The password for the IMAP Mailbox.');
$arrLang['imapOptions']         = array('IMAP Options', 'Additional options that should be added within imap_open().');
$arrLang['imapRetriesNum']      = array('IMAP Maximum connect attempts', 'Enter the number of maximum connect attempts. (default: 0)');
$arrLang['attachmentsDir']      = array('Attachment Directory', 'Select the directory where attachments should be stored.');
$arrLang['expungeOnDisconnect'] = array('Expunge on disconnect', 'Clean up Mailbox on disconnect if MOVE or DELETE has been called.');
$arrLang['imapSearchCriteria']  = array('IMAP search criteria', 'Enter IMAP search criteria that should filter the observed mailbox.');
$arrLang['cronInterval']        = array('CRON Interval', 'Choose the interval you would like to have this observer be invoked.');
$arrLang['useCronExpression']   = array('Use CRON expression', 'Add CRON Expressions that representing the schedule for executing this observer.');
$arrLang['cronExpression']      = array('CRON Expression', 'A CRON expression is a string representing the schedule for executing this observer.');
$arrLang['priority']            = array('Priority', 'Enter a value between 0 and 999. Priority will order execution of observer in ascending priority.');
$arrLang['invoked']             = array('Last invocation', 'The date of the last invocation of this observer.');
$arrLang['observer']            = array('Observer', 'Please select a observer.');
$arrLang['addObserverCriteria'] = array('Add observer criteria', 'Add states, that will be used to check against already invoked actions.');
$arrLang['observerCriteria']    = array('Observer criteria', 'Enter multiple observer states, separated by comma that will be skipped on next invocation.');
$arrLang['debug']               = array('Debug mode', 'Enable the debug mode and more information will be added to the observer log.');
$arrLang['published']           = array('Enable', 'Enable the on the website.');
$arrLang['start']               = array('Show from', 'Do not enable the Observer before this date.');
$arrLang['stop']                = array('Show until', 'Disable the Observer after this date.');
$arrLang['tstamp']              = array('Revision date', '');


/**
 * Legends
 */
$arrLang['general_legend']  = 'General settings';
$arrLang['mailbox_legend']  = 'Mailbox settings';
$arrLang['cronjob_legend']  = 'Cronjob settings';
$arrLang['observer_legend'] = 'Observer settings';
$arrLang['expert_legend']   = 'Expert settings';
$arrLang['publish_legend']  = 'Activation';


/**
 * Buttons
 */
$arrLang['new']    = array('New Observer', 'Observer create');
$arrLang['edit']   = array('Edit Observer', 'Edit Observer ID %s');
$arrLang['copy']   = array('Duplicate Observer', 'Duplicate Observer ID %s');
$arrLang['delete'] = array('Delete Observer', 'Delete Observer ID %s');
$arrLang['toggle'] = array('Publish/unpublish Observer', 'Publish/unpublish Observer ID %s');
$arrLang['log']    = array('Show log', 'Show the log of Observer ID %s');
$arrLang['run']    = array('Show run log', 'Show the run log of Observer ID %s');
$arrLang['show']   = array('Observer details', 'Show the details of Observer ID %s');
