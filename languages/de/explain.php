<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


$arrLang = &$GLOBALS['TL_LANG']['XPL'];

$arrLang['imapSearchCriteria'][0][0] = 'Kritrien';
$arrLang['imapSearchCriteria'][0][1] = '<ul>
        <li>
         <spa>
          ALL - return all messages matching the rest of the criteria
         </span>
        </li>
        <li>
         <spa>
          ANSWERED - match messages with the \\ANSWERED flag set
         </span>
        </li>
        <li>
         <spa>
          BCC "string" - match messages with "string" in the Bcc: field
         </span>
        </li>
        <li>
         <spa>
          BEFORE "date" - match messages with Date: before "date"
         </span>
        </li>
        <li>
         <spa>
          BODY "string" - match messages with "string" in the body of the message
         </span>
        </li>
        <li>
         <spa>
          CC "string" - match messages with "string" in the Cc: field
         </span>
        </li>
        <li>
         <spa>
          DELETED - match deleted messages
         </span>
        </li>
        <li>
         <spa>
          FLAGGED - match messages with the \\FLAGGED (sometimes
          referred to as Important or Urgent) flag set
         </span>
        </li>
        <li>
         <spa>
          FROM "string" - match messages with "string" in the From: field
         </span>
        </li>
        <li>
         <spa>
          KEYWORD "string" - match messages with "string" as a keyword
         </span>
        </li>
        <li>
         <spa>
          NEW - match new messages
         </span>
        </li>
        <li>
         <spa>
          OLD - match old messages
         </span>
        </li>
        <li>
         <spa>
          ON "date" - match messages with Date: matching "date"
         </span>
        </li>
        <li>
         <spa>
          RECENT - match messages with the \\RECENT flag set
         </span>
        </li>
        <li>
         <spa>
          SEEN - match messages that have been read (the \\SEEN flag is set)
         </span>
        </li>
        <li>
         <spa>
          SINCE "date" - match messages with Date: after "date"
         </span>
        </li>
        <li>
         <spa>
          SUBJECT "string" - match messages with "string" in the Subject:
         </span>
        </li>
        <li>
         <spa>
          TEXT "string" - match messages with text "string"
         </span>
        </li>
        <li>
         <spa>
          TO "string" - match messages with "string" in the To:
         </span>
        </li>
        <li>
         <spa>
          UNANSWERED - match messages that have not been answered
         </span>
        </li>
        <li>
         <spa>
          UNDELETED - match messages that are not deleted
         </span>
        </li>
        <li>
         <spa>
          UNFLAGGED - match messages that are not flagged
         </span>
        </li>
        <li>
         <spa>
          UNKEYWORD "string" - match messages that do not have the
          keyword "string"
         </span>
        </li>
        <li>
         <spa>
          UNSEEN - match messages which have not been read yet
         </span>
        </li>
       </ul>';

$arrLang['cronExpression'][0][0] = 'Description';
$arrLang['cronExpression'][0][1] = "A CRON expression is a string representing the schedule for a particular command to execute. The parts of a CRON schedule are as follows:
<pre>    *    *    *    *    *    *
    -    -    -    -    -    -
    |    |    |    |    |    |
    |    |    |    |    |    + year [optional]
    |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)</pre>";

$arrLang['cronExpression'][1][0] = 'Examples';
$arrLang['cronExpression'][1][1] = "<table cellpadding=\"3\" cellspacing=\"1\">
    <tbody>
        <tr>
            <th width=\"200\">**Expression**</th>
            <th>**Meaning**</th>
        </tr>
        <tr>
            <td>0 0 12 * * *</td>

            <td>Fire at 12pm (noon) every day</td>
        </tr>
        <tr>
            <td>0 15 10 * * *</td>
            <td>Fire at 10:15am every day</td>
        </tr>
        <tr>
            <td>0 15 10 * * *</td>

            <td>Fire at 10:15am every day</td>
        </tr>
        <tr>
            <td>0 15 10 * * * *</td>
            <td>Fire at 10:15am every day</td>
        </tr>
        <tr>
            <td>0 15 10 * * * 2005</td>

            <td>Fire at 10:15am every day during the year 2005</td>
        </tr>
        <tr>
            <td>0 * 14 * * *</td>
            <td>Fire every minute starting at 2pm and ending at 2:59pm, every day</td>
        </tr>
        <tr>
            <td>0 0/5 14 * * *</td>

            <td>Fire every 5 minutes starting at 2pm and ending at 2:55pm, every day</td>
        </tr>
        <tr>
            <td>0 0/5 14,18 * * *</td>
            <td>Fire every 5 minutes starting at 2pm and ending at 2:55pm, AND fire every 5
            minutes starting at 6pm and ending at 6:55pm, every day</td>
        </tr>
        <tr>
            <td>0 0-5 14 * * *</td>

            <td>Fire every minute starting at 2pm and ending at 2:05pm, every day</td>
        </tr>
        <tr>
            <td>0 10,44 14 * 3 WED</td>
            <td>Fire at 2:10pm and at 2:44pm every Wednesday in the month of March.</td>
        </tr>
        <tr>
            <td>0 15 10 * * MON-FRI</td>

            <td>Fire at 10:15am every Monday, Tuesday, Wednesday, Thursday and Friday</td>
        </tr>
        <tr>
            <td>0 15 10 15 * *</td>
            <td>Fire at 10:15am on the 15th day of every month</td>
        </tr>
        <tr>
            <td>0 15 10 L * *</td>

            <td>Fire at 10:15am on the last day of every month</td>
        </tr>
        <tr>
            <td>0 15 10 L-2 * *</td>

            <td>Fire at 10:15am on the 2nd-to-last last day of every month</td>
        </tr>
        <tr>
            <td>0 15 10 * * 6L</td>
            <td>Fire at 10:15am on the last Friday of every month</td>
        </tr>
        <tr>
            <td>0 15 10 * * 6L</td>

            <td>Fire at 10:15am on the last Friday of every month</td>
        </tr>
        <tr>
            <td>0 15 10 * * 6L 2002-2005</td>
            <td>Fire at 10:15am on every last friday of every month during the years 2002,
            2003, 2004 and 2005</td>
        </tr>
        <tr>
            <td>0 15 10 * * 6#3</td>

            <td>Fire at 10:15am on the third Friday of every month</td>
        </tr>
        <tr>
            <td>0 0 12 1/5 * *</td>
            <td>Fire at 12pm (noon) every 5 days every month, starting on the first day of the
            month.</td>
        </tr>
        <tr>
            <td>0 11 11 11 11 *</td>

            <td>Fire every November 11th at 11:11am.</td>
        </tr>
    </tbody>
</table>";