<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_observer'];

/**
 * Fields
 */
$arrLang['title']               = ['Titel', 'Geben Sie hier bitte den Titel ein.'];
$arrLang['subject']             = ['Subjekt', 'Wählen Sie hier ein Subjekt aus.'];
$arrLang['addContextAge']       = [
    'Minimales Kontextalter hinzufügen',
    'Wählen Sie diese Option, wenn ein Kontext erst ein bestimmtes Alter erreichen muss, bevor er verarbeitet wird.'
];
$arrLang['contextAgeAttribute'] = ['Kontextalter-Attribut', 'Wählen Sie hier ein passendes Attribut aus (Standard: tstamp).'];
$arrLang['contextAge']          = [
    'Kontextalter (in s)',
    'Geben Sie hier das minimale Kontextalter (in s) ein (Standard: 5 Minuten; Wert: 300).'
];
$arrLang['imapPath']            = ['Pfad', 'Geben Sie hier den Pfad zum Postfach ein (Beispiel: {imap.gmail.com:993/imap/ssl}INBOX).'];
$arrLang['imapLogin']           = ['Benutzername', 'Geben Sie hier den Benutzername ein.'];
$arrLang['imapPassword']        = ['Passwort', 'Geben Sie hier das IMAP-Passwort ein.'];
$arrLang['imapOptions']         = ['Optionen', 'Geben Sie hier zusätzliche Optionen ein, die in imap_open() verwendet werden sollen.'];
$arrLang['imapRetriesNum']      = ['Maximale Verbindungsversuche', 'Geben Sie hier die maximale Anzahl an Verbindungsversuchen ein (Standard: 0).'];
$arrLang['attachmentsDir']      = ['Verzeichnis für Anhänge', 'Wählen Sie hier das Verzeichnis aus, in dem Anhänge gespeichert werden sollen.'];
$arrLang['expungeOnDisconnect'] = [
    'Mailbox nach Verbindungsabbruch leeren',
    'Wählen Sie diese Option, um die Mailbox nach Verbindungsabbruch leeren, wenn vorher ein MOVE oder DELETE aufgerufen wurde.'
];
$arrLang['imapSearchCriteria']  = ['Suchkriterien', 'Geben Sie hier die Suchkriterien ein, nach denen gefiltert wird.'];
$arrLang['cronInterval']        = ['CRON-Intervall', 'Wählen Sie hier das Intervall aus, in dem der Observer ausgeführt werden soll.'];
$arrLang['useCronExpression']   = ['CRON-Ausdruck verwenden (überdefiniert "CRON-Intervall")', 'Definieren Sie das zeitliche Ausführungmuster als CRON-Ausdruck.'];
$arrLang['cronExpression']      = ['CRON-Ausdruck', 'Geben Sie hier den gewünschten CRON-Ausdruck ein.'];
$arrLang['priority']            =
    ['Priorität', 'Geben Sie einen Wert von 0 bis 999 ein. Die Observer werden mit aufsteigendem Prioritätswert ausgeführt (0 vor 1).'];
$arrLang['invoked']             = ['Letzter Aufruf', 'In diesem Feld wird das Datum des letzten Aufrufs gespeichert.'];
$arrLang['invokedState']        = ['Zustand des letzten Aufrufs', 'In diesem Feld wird der Zustand des letzten Aufrufs gespeichert.'];
$arrLang['observer']            = ['Observer', 'Wählen Sie hier einen Observer aus.'];
$arrLang['addObserverStates']   = [
    'Observerzustände hinzufügen',
    'Fügen Sie Zustände hinzu, die an neuen Log-Einträgen hinterlegt werden sollen (Verhinderung, dass ein Kontext mehrfach verarbeitet wird).'
];
$arrLang['observerStates']      = [
    'Observerzustände',
    'Wählen Sie hier die Zustände aus, die neuen History-Einträgen hinzugefügt werden und dazu führen, dass ein Import nicht neu angestoßen wird. (Standard: "Erfolg").'
];
$arrLang['notification']        = ['Benachrichtigung', 'Wählen Sie hier eine Benachrichtigung aus.'];
$arrLang['members']             = ['Mitglieder', 'Wählen Sie hier Mitglieder aus.'];
$arrLang['memberGroups']        = ['Mitgliedergruppen', 'Wählen Sie hier Mitgliedergruppen aus.'];
$arrLang['limitMembers']        = ['Mitglieder eingrenzen', 'Schränken Sie hier die Mitglieder weiter ein.'];
$arrLang['memberGroupMembers']  = ['Mitglieder aus Mitgliedergruppen', 'Wählen Sie hier Mitglieder aus den gewählten Gruppen aus.'];
$arrLang['debug']               = ['Debug-Modus', 'Aktivieren Sie diese Option, damit mehr Informationen zum Observer-Log hinzugefügt werden.'];
$arrLang['published']           = ['Aktivieren', 'Wählen Sie diese Option zum aktivieren des Observer.'];
$arrLang['start']               = ['Aktivieren ab', 'Observer erst ab diesem Tag aktivieren.'];
$arrLang['stop']                = ['Aktivieren bis', 'Observer nur bis zu diesem Tag aktivieren.'];
$arrLang['tstamp']              = ['Änderungsdatum', ''];


/**
 * Placeholders
 */
$arrLang['placeholder']['members']            = 'Wählen Sie hier ein oder mehrere Mitglieder aus.';
$arrLang['placeholder']['memberGroups']       = 'Wählen Sie hier eine oder mehrere Mitgliedergruppen aus.';
$arrLang['placeholder']['memberGroupMembers'] = 'Wählen Sie hier ein oder mehrere Mitglieder aus.';

/**
 * Legends
 */
$arrLang['general_legend']  = 'Allgemeine Einstellungen';
$arrLang['mailbox_legend']  = 'Mailbox';
$arrLang['cronjob_legend']  = 'Cronjob';
$arrLang['observer_legend'] = 'Observer';
$arrLang['expert_legend']   = 'Experteneinstellungen';
$arrLang['publish_legend']  = 'Aktivierung';


/**
 * Buttons
 */
$arrLang['new']     = ['Neuer Observer', 'Observer erstellen'];
$arrLang['edit']    = ['Observer bearbeiten', 'Observer ID %s bearbeiten'];
$arrLang['copy']    = ['Observer duplizieren', 'Observer ID %s duplizieren'];
$arrLang['delete']  = ['Observer löschen', 'Observer ID %s löschen'];
$arrLang['toggle']  = ['Observer veröffentlichen', 'Observer ID %s veröffentlichen/verstecken'];
$arrLang['show']    = ['Observer Details', 'Observer-Details ID %s anzeigen'];
$arrLang['log']     = ['Log anzeigen', 'Log von Observer ID %s anzeigen'];
$arrLang['history'] = ['History anzeigen', 'History von Observer ID %s anzeigen'];