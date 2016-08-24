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

use HeimrichHannot\Haste\Model\MemberModel;

abstract class NotificationObserver extends Observer
{
	/**
	 * The current notified member object
	 *
	 * @var MemberModel
	 */
	private $objMember;

	/**
	 * @param Subject The subject object
	 *
	 * @return boolean
	 */
	public function update(Subject $objSubject)
	{
		$this->objSubject = $objSubject;

		$objMembers = ObserverNotification::findToBeNotifiedMembers($this->getSubject()->getModel());

		$objMembers = $this->modifyMembers($objMembers);

		if ($objMembers === null)
		{
			return false;
		}

		while ($objMembers->next())
		{
			$this->objMember = $objMembers->current();

			$this->entityId = $this->getEntityId();

			$arrStates = array(Observer::STATE_SUCCESS);

			if ($objSubject->getModel()->addObserverStates)
			{
				$arrStates = deserialize($objSubject->getModel()->observerStates, true);
			}

			if (ObserverHistoryModel::hasRun($objSubject->getModel()->id, $this->getEntityId(), $arrStates))
			{
				return true;
			}

			$this->doUpdate();

			if (($objHistory = ObserverHistoryModel::findByParentAndEntityIdAndState($objSubject->getModel()->id, $this->getEntityId())) == null)
			{
				$objHistory = new ObserverHistoryModel();
			}

			$objHistory->pid      = $objSubject->getModel()->id;
			$objHistory->tstamp   = time();
			$objHistory->entityId = $this->getEntityId();
			$objHistory->state    = $this->getState();
			$objHistory->save();
		}

		return true;
	}

	protected function doUpdate()
	{
		$blnReturn = $this->createNotification();

		if (!$this->getState())
		{
			$this->setState($blnReturn ? Observer::STATE_SUCCESS : Observer::STATE_ERROR);
		}
	}

	/**
	 * Get the current notified member object
	 *
	 * @return MemberModel
	 */
	public function getMember()
	{
		return $this->objMember;
	}

	/**
	 * Modify members
	 *
	 * @param \Model\Collection|null $objMembers
	 *
	 * @return \Model\Collection|null Return the collection of member entities or null
	 */
	protected function modifyMembers($objMembers = null)
	{
		return $objMembers;
	}

	abstract protected function createNotification();
}