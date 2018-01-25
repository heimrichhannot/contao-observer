# Observer

A observer for contao. It is currently required by [heimrichhannot/contao-collab](https://github.com/heimrichhannot/contao-collab) and provide task creation from a mailbox, or notify task assignees.
But it can be extended easily.

## Features

The observer is a cron-job module, that checks subjects against given criteria and update attached observers.
It structure is based on the observer pattern. We have subjects like a mailbox for example. If a mail with given criteria (for example new mail) will
be received, the attached Taskobserver will create a new Task from a given mail ([heimrichhannot/contao-collab](https://github.com/heimrichhannot/contao-collab) required).

- Observe a mailbox (php-imap php extension is required)
- Wait for subject age (wait until tstamp of context elapsed given waiting duration)
- Priority handling (manage execution order)
- Observer log
- Observer history: store all already run subject/observer combinations within local history (e.g. will prevent multiple user notification)

### Observer manager

The observer manager observes all entities withing the minutely contao cron job. It works within the poor man's minutly cronjob out of the box, or you can call the binary script within you crontab:

Contao 3 without composer:

```
* * * * * php /path/to/contao/system/modules/observer/bin/manager.php
```

Contao 3 with composer:
```
* * * * * php /path/to/contao/composer/vendor/heimrichhannot/contao-observer/bin/manager.php
```

Contao 4:
```
* * * * * php /path/to/contao/vendor/heimrichhannot/contao-observer/bin/manager.php
```

### Make usage within you custom module

#### Add a new subject

A subject is for example a mailbox, or tasks within a given tasklist, with needed criteria (UNSEEN Mail, unassigned Tasks…).

#####  1. Add the subject to your config.php

```
// config.php
array_insert(
	$GLOBALS['OBSERVER']['SUBJECTS'],
	0,
	[
		'MY_SUBJECT_NAME' => 'MyNamespace\Observer\MySubject',
	]
);
```

#####  2. Add your subject palette to tl_observer.php

You might add custom fields also in here.

```
// tl_observer.php

$arrDca = &$GLOBALS['TL_DCA']['tl_observer'];

/**
 * Palettes
 */
$arrDca['palettes']['MY_SUBJECT_NAME'] =
	'{general_legend},subject,title;{cronjob_legend},cronInterval,useCronExpression,priority,invoked,invokedState;{observer_legend},observer;{expert_legend},debug,addObserverStates;{publish_legend},published;';
```

##### 3. Create your Subject Object 'MyNamespace\Observer\MySubject'

Must extend `HeimrichHannot\Observer\Subject`.
```
<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace MyNamespace\Observer;

use HeimrichHannot\Observer\ObserverLog;
use HeimrichHannot\Observer\Subject;

class TaskSubject extends Subject
{
	/**
	 * Run your subject observer
	 *
	 * @return bool True on success, false on error
	 */
	public function notify()
	{
		$arrLists    = deserialize($this->getObserver()->tasklists, true);
		$arrCriteria = deserialize($this->getObserver()->taskCriteria, true);

		$objTasks = TaskModel::findByListsAndCriteria($arrLists, $arrCriteria);

		if ($objTasks === null)
		{
			if ($this->getObserver()->debug)
			{
				ObserverLog::add($this->getObserver()->id, 'No tasks for given filter found.', __CLASS__ . ':' . __METHOD__);
			}

			return;
		}

		if ($this->getObserver()->debug)
		{
			$count = $objTasks->count();
			ObserverLog::add($this->getObserver()->id, $count . ($count == 1 ? ' Task' : ' Tasks') . ' found for given filter.', __CLASS__ . ':' . __METHOD__);
		}

		while ($objTasks->next())
		{
			$this->context = $objTasks->current();

			if (!$this->waitForContext($this->context))
			{
				if ($this->getObserver()->debug)
				{
					ObserverLog::add($this->getObserver()->id, 'Observers updated with task: "' . $objTasks->title . '" [ID:' . $objTasks->id .  '].', __CLASS__ . ':' . __METHOD__);
				}

				foreach ($this->observers as $obs)
				{
					$obs->update($this);
				}

				continue;
			}

			if ($this->getObserver()->debug)
			{
				ObserverLog::add($this->getObserver()->id, 'Waiting time for task: "' . $objTasks->title . '" [ID:' . $objTasks->id .  '] not elapsed yet.', __CLASS__ . ':' . __METHOD__);
			}
		}

		return true;
	}
}
```

#### Add a new observer

A observer is for example a notification, that will be send to a given member (for example a task assignee) when a subject with given criteria were found.

#####  1. Add the observer to your config.php

```
// config.php
array_insert(
	$GLOBALS['OBSERVER']['OBSERVERS'],
	0,
	[
		'MY_OBSERVER_NAME' => 'MyNamespace\Observer\MyObserver',
	]
);
```

##### 2. Create your Observer Object 'MyNamespace\Observer\MyObserver'

Must extend `HeimrichHannot\Observer\Observer`.
```
<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Collab\Observer;


use HeimrichHannot\Collab\CollabConfig;
use HeimrichHannot\Collab\Helper\TaskHelper;
use HeimrichHannot\Haste\Model\Model;
use HeimrichHannot\Observer\NotificationObserver;
use HeimrichHannot\Observer\Observer;
use HeimrichHannot\Observer\ObserverNotification;
use HeimrichHannot\Versions\VersionModel;

class TaskNotificationObserver extends NotificationObserver
{
    // optionally define new states for your observer
    const STATE_EXISTING = 'existing';
    
    const STATES = [
        self::STATE_SUCCESS,
        self::STATE_EXISTING,
        self::STATE_ERROR
    ];
    
	protected function createNotification()
	{
		ObserverNotification::sendNotification(
			$this->objSubject->getObserver()->notification,
			$this->objSubject->getObserver(),
			$this->objSubject->getContext(),
			$this->getMember()
		);

		// as mails might sent from queue it is not possible to determine if there were mail errors
		return Observer::STATE_SUCCESS;
	}

	protected function getEntityId()
	{
		// Add the version to the entity id, as we build on versions
		$objVersion = VersionModel::findCurrentByModel($this->getSubject()->getContext());

		return sprintf(
			'%s_%s:%s_%s:%s_%s',
			$this->getSubject()->getContext()->getTable(),
			$this->getSubject()->getContext()->id,
			$this->getMember()->getTable(),
			$this->getMember()->id,
			'tl_version',
			$objVersion === null ? '0' : $objVersion->id
		);

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
		// notify if assigneeType is member and authorType is not user and author != assignee
		if ($this->getSubject()->getContext()->assigneeType == CollabConfig::AUTHOR_TYPE_MEMBER)
		{
			$objAuthor = TaskHelper::getCurrentAuthor($this->getSubject()->getContext());
			$objAssignee = TaskHelper::getCurrentAssignee($this->getSubject()->getContext());

			// add current assignee
			if ($this->getSubject()->getObserver()->notifyAssignee && $objAssignee !== null)
			{
				// skip if author is assignee
				if ($objAuthor->id != $objAssignee->id)
				{
					$objMembers = Model::addModelToCollection($objAssignee, $objMembers);
				}
			}

			// add previous assignee
			if($this->getSubject()->getObserver()->notifyPreviousAssignee)
			{
				if (($objPreviousAssignee = TaskHelper::getPreviousAssignee($this->getSubject()->getContext())) !== null)
				{
					$objMembers = Model::addModelToCollection($objPreviousAssignee, $objMembers);
				}
			}

			// remove current assignee
			if($this->getSubject()->getObserver()->skipNotifyAssignee && $objAssignee !== null)
			{
				$objMembers = Model::removeModelFromCollection($objAssignee, $objMembers);
			}

			// remove previous assignee
			if($this->getSubject()->getObserver()->skipNotifyPreviousAssignee)
			{
				if (($objPreviousAssignee = TaskHelper::getPreviousAssignee($this->getSubject()->getContext())) !== null)
				{
					$objMembers = Model::removeModelFromCollection($objPreviousAssignee, $objMembers);
				}
			}
		}

		return $objMembers;
	}

    // optional
	public static function getPalettes(\DataContainer $dc = null)
	{
		return [
			CollabConfig::OBSERVER_SUBJECT_TASK => 'notification,notifyAssignee,notifyPreviousAssignee,members,memberGroups,limitMembers,skipNotifyAssignee,skipNotifyPreviousAssignee',
		];
	}


}
```

The getPalettes Method is required, to make a observer related to multiple given subjects. The key of the array pair must be the subject name and the value should contain all fields, that should
be added to the tl_observer.php palette (after the oberserver selection dropdown) for the given subject palette.