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

use HeimrichHannot\Haste\Dca\Notification;
use HeimrichHannot\Haste\Model\MemberModel;
use HeimrichHannot\Haste\Util\StringUtil;
use HeimrichHannot\Observer\Observer as ObserverClass;
use HeimrichHannot\Observer\ObserverConfig;
use HeimrichHannot\Observer\ObserverLog;
use HeimrichHannot\Observer\ObserverManager;
use HeimrichHannot\Observer\ObserverModel;
use HeimrichHannot\Observer\ObserverNotification;

class Observer extends \Backend
{

    public function modifyDc(\DataContainer $dc)
    {
        if (($objModel = ObserverModel::findByPk($dc->id)) === null || !$objModel->subject)
        {
            return;
        }


        if (($objSubject = ObserverManager::findSubjectByModel($objModel)) === null)
        {
            return;
        }


        if (($objObserver = ObserverManager::findObserverBySubject($objSubject)) === null)
        {
            return;
        }

        $arrDca      = &$GLOBALS['TL_DCA']['tl_observer'];
        $arrPalettes = $objObserver::getPalettes($dc);

        if (!is_array($arrPalettes) || !is_array($arrDca['palettes']))
        {
            return;
        }

        foreach ($arrPalettes as $strKey => $strInvocation)
        {
            // skip if observer does not exist
            if (!isset($arrDca['palettes'][$strKey]))
            {
                continue;
            }

            if (!StringUtil::startsWith($strInvocation, '{'))
            {
                $strInvocation = ',' . ltrim($strInvocation, ',;');
            }


            $arrDca['palettes'][$strKey] = str_replace(',observer', ',observer' . $strInvocation, $arrDca['palettes'][$strKey]);
        }
    }

    /**
     * Modify the backend group title and add the action
     *
     * @param                $group
     * @param                $mode
     * @param                $field
     * @param                $row
     * @param \DataContainer $dc
     *
     * @return string
     */
    public function getGroupTitle($group, $mode, $field, $row, \DataContainer $dc)
    {
        $strSubject  = $GLOBALS['TL_LANG']['OBSERVER_SUBJECT'][$row['subject']] ?: $row['subject'];
        $strObserver = $GLOBALS['TL_LANG']['OBSERVER_OBSERVER'][$row['observer']] ?: $row['observer'];

        return sprintf(
            '<span class="tl_blue">%s: %s</span> &raquo; %s: %s',
            $GLOBALS['TL_LANG']['MSC']['observer']['subject'],
            $strSubject,
            $GLOBALS['TL_LANG']['MSC']['observer']['observer'],
            $strObserver
        );
    }

    /**
     * Colorize the entries depending on their latest invocation
     *
     * @param array  $arrRow
     * @param string $label
     *
     * @return string
     */
    public function colorize($arrRow, $label)
    {
        $strClass = ObserverLog::getColorClassFromAction($arrRow['invokedState']);

        $strClass = ($strClass ? ' class="' . $strClass . '"' : '');

        $strLabel = sprintf(
            '<div class="ellipsis">%s%s%s</div>',
            $arrRow['title'],
            $arrRow['invoked'] ? '<span style="padding-left:3px"' . $strClass . '>[' . \Date::parse(\Config::get('datimFormat'), $arrRow['invoked'])
                                 . ']</span>' : '',
            ' [' . $arrRow['priority'] . ']'
        );

        return $strLabel;
    }

    /**
     * On create callback
     *
     * @param                $strTable
     * @param                $insertID
     * @param                $arrSet
     * @param \DataContainer $dc
     */
    public function onCreate($strTable, $insertID, $arrSet, \DataContainer $dc)
    {
        if (($objModel = ObserverModel::findByPk($insertID)) === null)
        {
            return;
        }

        if (($uuid = ObserverConfig::getDefaultAttachmentsDir()) !== null && \Validator::isUuid($uuid))
        {
            $objModel->attachmentsDir = \StringUtil::uuidToBin($uuid);
        }

        $objModel->save();
    }

    /**
     * Set default attachment dir
     *
     * @param                $varValue
     * @param \DataContainer $dc
     *
     * @return mixed
     */
    public function setAttachmentsDir($varValue, \DataContainer $dc)
    {
        if ($varValue == '')
        {
            return ObserverConfig::getDefaultAttachmentsDir();
        }

        return $varValue;
    }


    public function getCronIntervals(\DataContainer $dc)
    {
        return ObserverConfig::getCronIntervals();
    }


    /**
     * Get all observer states
     *
     * @param \DataContainer $dc
     *
     * @return array
     */
    public function getObserverStates(\DataContainer $dc)
    {
        return ObserverClass::getStates($dc);
    }

    /**
     * Get all subjects as array
     *
     * @param \DataContainer $dc
     *
     * @return array
     */
    public function getSubjects(\DataContainer $dc)
    {
        return ObserverConfig::getSubjects();
    }

    /**
     * Get all observer within selected subject
     *
     * @param \DataContainer $dc
     *
     * @return array
     */
    public function getObservers(\DataContainer $dc)
    {
        $objModel = ObserverModel::findByPk($dc->id);

        if ($objModel === null)
        {
            return [];
        }

        return ObserverConfig::getObserverByModel($objModel);
    }

    /**
     * Get all available notifications
     *
     * @param \DataContainer $dc
     *
     * @return array
     */
    public function getNotifications(\DataContainer $dc)
    {
        return Notification::getNotificationMessagesAsOptions($dc, ObserverNotification::NOTIFICATION_TYPE_OBSERVER_NOTIFICATION);
    }

    /**
     * Get all members from selected member groups as options
     *
     * @return array
     */
    public function getMemberGroupMembers(\DataContainer $dc)
    {
        $arrOptions = [];

        $objObserver = ObserverModel::findByPk($dc->id);

        if ($objObserver === null)
        {
            return $arrOptions;
        }

        $arrGroups = deserialize($objObserver->memberGroups, true);

        $objMembers = MemberModel::findActiveByGroups($arrGroups);

        if ($objMembers === null)
        {
            return $arrOptions;
        }

        while ($objMembers->next())
        {
            $arrOptions[$objMembers->id] = sprintf('%s %s [ID:%s]', $objMembers->lastname, $objMembers->firstname, $objMembers->id);
        }

        return $arrOptions;
    }


}