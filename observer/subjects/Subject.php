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


abstract class Subject
{
	protected $objModel;

	protected $context;

	protected $observers = array();

	public function __construct(ObserverModel $objModel)
	{
		$this->objModel = $objModel;
	}

	public function attach(Observer $objObserver)
	{
		$this->observers[] = $objObserver;
	}

	public function detach(Observer $objObserver)
	{
		foreach ($this->observers as $okey => $oval)
		{
			if ($oval == $objObserver)
			{
				unset($this->observers[$okey]);
			}
		}
	}

	public function notify()
	{
		foreach ($this->observers as $obs)
		{
			$obs->update($this);
		}
	}

	/**
	 * @return ObserverModel
	 */
	public function getModel()
	{
		return $this->objModel;
	}

	/**
	 * @return mixed
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param mixed $context
	 */
	public function setContext($context)
	{
		$this->context = $context;
	}
}