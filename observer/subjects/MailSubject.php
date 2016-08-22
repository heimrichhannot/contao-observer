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


use HeimrichHannot\Haste\Util\Files;
use PhpImap\Mailbox;

class MailSubject extends Subject
{
	/**
	 * Run the mail observer
	 * @return bool True on success, false on error
	 */
	public function notify()
	{
		$objMailBox = new Mailbox(
			$this->objModel->imapPath,
			$this->objModel->imapLogin,
			\Encryption::decrypt($this->objModel->imapPassword),
			TL_ROOT . '/' . Files::getPathFromUuid($this->objModel->attachmentsDir)
		);

		$objMailBox->setConnectionArgs($this->getModel()->imapOptions ?: 0, $this->objModel->imapRetriesNum ?: 0, array());

		// Read all messaged into an array:
		$arrMailIds = $objMailBox->searchMailbox($this->getModel()->imapSearchCriteria);

		if(!$arrMailIds)
		{
			if($this->getModel()->debug)
			{
				ObserverLog::add($this->getModel()->id, 'Mailbox is empty', __CLASS__ . ':' . __METHOD__);
			}

			return false;
		}

		// put the newest mails on top
		rsort($arrMailIds);

		if($this->getModel()->debug)
		{
			$count = count($arrMailIds);
			ObserverLog::add($this->getModel()->id, $count . ($count == 1 ? ' Mail' : ' Mails') .' in Mailbox', __CLASS__ . ':' . __METHOD__);
		}

		foreach ($arrMailIds as $mailId)
		{
			/**  @var \PhpImap\IncomingMail */
			$this->context = $objMailBox->getMail($mailId);

			foreach ($this->observers as $obs)
			{
				$obs->update($this);
			}
		}

		return true;
	}
}