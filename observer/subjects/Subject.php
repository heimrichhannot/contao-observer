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
    protected $objObserver;

    protected $context;

    protected $observers = [];

    public function __construct(ObserverModel $objObserver)
    {
        $this->objObserver = $objObserver;
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
    public function getObserver()
    {
        return $this->objObserver;
    }

    /**
     * @deprecated Use getObserver() instead
     */
    public function getModel()
    {
        return $this->objObserver;
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

    /**
     * Check the context against its age and return true if the waiting time elapsed
     *
     * @internal Use before the observer will be updated
     *
     * @param $context   The context entity
     * @param $attribute Overwrite the contextAgeAttribute
     *
     * @return bool Return true if the current context should not be updated within the observer
     */
    public function waitForContext($context, $attribute = null)
    {
        if (!$this->getObserver()->addContextAge)
        {
            return false;
        }

        if ($attribute === null)
        {
            $attribute = $this->getObserver()->contextAgeAttribute;
        }

        $seconds = $this->getObserver()->contextAge;
        $tstamp  = null;
        $time    = time();

        if (is_object($context))
        {
            if (!isset($context->{$attribute}))
            {
                return false;
            }

            $tstamp = $context->{$attribute};
        }
        else
        {
            if (is_array($context))
            {
                if (!isset($context[$attribute]))
                {
                    return false;
                }

                $tstamp = $context[$attribute];
            }
        }

        if ($tstamp === null)
        {
            return false;
        }

        // date format no timestamp yet
        if (strtotime($tstamp) !== false)
        {
            $tstamp = strtotime($tstamp);
        }

        return ($time - $seconds) <= $tstamp;
    }
}