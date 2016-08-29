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
use HeimrichHannot\Haste\Util\Classes;
use HeimrichHannot\Versions\VersionModel;

abstract class Observer
{
	const STATE_ERROR   = 'error';
	const STATE_SUCCESS = 'success';

	/**
	 * The current child entity identifier
	 *
	 * @var mixed
	 */
	protected $entityId;

	/**
	 * The current observer state
	 *
	 * @var string
	 */
	protected $state;

	/**
	 * The current Subject, for internal usage
	 *
	 * @var Subject
	 */
	protected $objSubject;

	/**
	 * @param Subject The subject object
	 *
	 * @return boolean
	 */
	public function update(Subject $objSubject)
	{
		$this->objSubject = $objSubject;

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

		return true;
	}

	abstract protected function doUpdate();

	/**
	 * @param \DataContainer $dc
	 *
	 * @return array of modified palettes (key = palettes, value = fields that should be invoked after the action field)
	 */
	abstract public static function getPalettes(\DataContainer $dc = null);

	/**
	 * Return the current entity identifier which child of the subject
	 *
	 * @return mixed
	 */
	abstract protected function getEntityId();

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param mixed $state
	 */
	public function setState($state)
	{
		$this->state = $state;
	}

	/**
	 * @return Subject
	 */
	public function getSubject()
	{
		return $this->objSubject;
	}

	public static function getStates()
	{
		return Classes::getConstantsByPrefixes(__CLASS__, array('STATE_'));
	}
}