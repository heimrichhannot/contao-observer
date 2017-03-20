<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Observer;


use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\Haste\DC_Table;
use HeimrichHannot\Haste\Model\MemberModel;
use HeimrichHannot\Haste\Util\FormSubmission;
use HeimrichHannot\NotificationCenterPlus\NotificationCenterPlus;
use HeimrichHannot\Submissions\SubmissionModel;
use NotificationCenter\Model\Message;

class ObserverNotification
{
	const NOTIFICATION_TYPE_OBSERVER              = 'observer';
	const NOTIFICATION_TYPE_OBSERVER_NOTIFICATION = 'observer_notification';

	public static function findToBeNotifiedMembers(ObserverModel $objObserver)
	{
		$arrGroups = array_filter(deserialize($objObserver->memberGroups, true));
		$arrMembers = array_filter(deserialize($objObserver->members, true));

		$arrIds = $arrMembers;

		$objGroupMembers = MemberModel::findActiveByGroups($arrGroups);

		if($objGroupMembers !== null)
		{
			$arrGroupMembers = $objGroupMembers->fetchEach('id');

			if($objObserver->limitMembers)
			{
				$arrGroupMembers = array_intersect($arrGroupMembers, array_filter(deserialize($objObserver->memberGroupMembers, true)));
			}

			$arrIds = array_merge($arrIds, $arrGroupMembers);
		}

		return MemberModel::findAllActiveByIds($arrIds);
	}

	public static function sendNotification($intMessage, ObserverModel $objObserver, \Model $objEntity, \MemberModel $objMember, $arrTokens = [])
	{
		if ($intMessage && ($objMessage = Message::findByPk($intMessage)) !== null)
		{
			$objMessage->entity   = $objEntity;
			$objMessage->member   = $objMember;
			$objMessage->observer = $objObserver;
			$objMessage->send(array_merge($arrTokens, static::generateTokens($objObserver, $objEntity, $objMember)), $objMember->language ?: 'en');
		}
	}

	public static function generateTokens(ObserverModel $objObserver, \Model $objEntity, \MemberModel $objMember)
	{
		$arrSet = [
			'observer_entity' => $objEntity,
			'observer_member' => $objMember];

		$arrTokens = [];

		foreach ($arrSet as $strGroup => $objModel)
		{
			$arrTokens = array_merge($arrTokens, FormSubmission::tokenizeData(FormSubmission::prepareData($objModel, $objModel->getTable()), $strGroup));
		}

		$arrTokens['salutation_member'] = NotificationCenterPlus::createSalutation($objMember->language ?: 'en', $objMember);

		return $arrTokens;
	}
}