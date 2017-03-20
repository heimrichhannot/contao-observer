<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Observer\Backend;


use HeimrichHannot\Observer\ObserverLog as ObserverLogClass;

class ObserverLog extends \Backend
{

    /**
     * Colorize the log entries depending on their category
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function colorize($arrRow)
    {
        $strClass = ObserverLogClass::getColorClassFromAction($arrRow['action']);

        $strClass = ($strClass ? ' ' : '') . $strClass;

        return '<div class="ellipsis ' . $strClass . '"><span style="padding-right:3px">[' . \Date::parse(
            \Config::get('datimFormat'),
            $arrRow['tstamp']
        ) . ']</span>' . $arrRow['text'] . '</div>';
    }
}