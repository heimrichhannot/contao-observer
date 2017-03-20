<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_observer'];

/**
 * Fields
 */
$arrLang['title']               = ['Title', 'Please enter a title.'];
$arrLang['subject']             = ['Subject', 'Please select a subject.'];
$arrLang['addContextAge']       = ['Wait for context age', 'Check option if you want to wait until the age of the context elapsed.'];
$arrLang['contextAgeAttribute'] = ['Context age attribute', 'Enter a valid context attribute, that should be checked against the context age (default: tstamp).'];
$arrLang['contextAge']          = ['Context age (in seconds)', 'Enter the age of the context seconds, that should be waited until the observer will be triggered (default: 5 minutes; value: 300).'];
$arrLang['imapPath']            = ['IMAP Path', 'The path to the IMAP Mailbox (e.g. {imap.gmail.com:993/imap/ssl}INBOX).'];
$arrLang['imapLogin']           = ['IMAP Login', 'The login/username for the IMAP Mailbox (e.g. some@gmail.com).'];
$arrLang['imapPassword']        = ['IMAP Password', 'The password for the IMAP Mailbox.'];
$arrLang['imapOptions']         = ['IMAP Options', 'Additional options that should be added within imap_open().'];
$arrLang['imapRetriesNum']      = ['IMAP Maximum connect attempts', 'Enter the number of maximum connect attempts. (default: 0)'];
$arrLang['attachmentsDir']      = ['Attachment Directory', 'Select the directory where attachments should be stored.'];
$arrLang['expungeOnDisconnect'] = ['Expunge on disconnect', 'Clean up Mailbox on disconnect if MOVE or DELETE has been called.'];
$arrLang['imapSearchCriteria']  = ['IMAP search criteria', 'Enter IMAP search criteria that should filter the observed mailbox.'];
$arrLang['cronInterval']        = ['CRON Interval', 'Choose the interval you would like to have this observer be invoked.'];
$arrLang['useCronExpression']   = ['Use CRON expression (overrides "CRON Interval")', 'Add CRON Expressions that representing the schedule for executing this observer.'];
$arrLang['cronExpression']      = ['CRON Expression', 'A CRON expression is a string representing the schedule for executing this observer.'];
$arrLang['priority']            = ['Priority', 'Enter a value between 0 and 999. Priority will order execution of observer in ascending priority.'];
$arrLang['invoked']             = ['Last invocation', 'The date of the last invocation of this observer.'];
$arrLang['invokedState']        = ['Last invocation state', 'The state of the last invocation of this observer.'];
$arrLang['observer']            = ['Observer', 'Please select a observer.'];
$arrLang['addObserverStates']   = ['Add observer states', 'Add states to the history entries and check them against if observer runs again.'];
$arrLang['observerStates']      = ['Observer states', 'Select multiple states, that will be added to new history entries and on next run all, if the incoming entityId has the same id and states, the entry will be skipped (Default: Success).'];
$arrLang['notification']        = ['Notification', 'Select a notification message, that you want to send.'];
$arrLang['members']             = ['Members', 'Select multiple members.'];
$arrLang['memberGroups']        = ['Member groups', 'Select multiple member groups.'];
$arrLang['limitMembers']        = ['Limit members', 'Limit members within the given member groups.'];
$arrLang['memberGroupMembers']  = ['Members from member groups', 'Select multiple members from the selected member groups.'];
$arrLang['debug']               = ['Debug mode', 'Enable the debug mode and more information will be added to the observer log.'];
$arrLang['published']           = ['Enable', 'Enable the on the website.'];
$arrLang['start']               = ['Show from', 'Do not enable the Observer before this date.'];
$arrLang['stop']                = ['Show until', 'Disable the Observer after this date.'];
$arrLang['tstamp']              = ['Revision date', ''];


/**
 * Placeholders
 */
$arrLang['placeholder']['members']            = 'Select multiple members.';
$arrLang['placeholder']['memberGroups']       = 'Select multiple member groups.';
$arrLang['placeholder']['memberGroupMembers'] = 'Select multiple members.';

/**
 * Legends
 */
$arrLang['general_legend']  = 'General settings';
$arrLang['mailbox_legend']  = 'Mailbox';
$arrLang['cronjob_legend']  = 'Cronjob';
$arrLang['observer_legend'] = 'Observer';
$arrLang['expert_legend']   = 'Expert settings';
$arrLang['publish_legend']  = 'Activation';


/**
 * Buttons
 */
$arrLang['new']    = ['New Observer', 'Observer create'];
$arrLang['edit']   = ['Edit Observer', 'Edit Observer ID %s'];
$arrLang['copy']   = ['Duplicate Observer', 'Duplicate Observer ID %s'];
$arrLang['delete'] = ['Delete Observer', 'Delete Observer ID %s'];
$arrLang['toggle'] = ['Publish/unpublish Observer', 'Publish/unpublish Observer ID %s'];
$arrLang['log']    = ['Show log', 'Show the log of Observer ID %s'];
$arrLang['run']    = ['Show run log', 'Show the run log of Observer ID %s'];
$arrLang['show']   = ['Observer details', 'Show the details of Observer ID %s'];
