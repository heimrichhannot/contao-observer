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
     *
     * @return bool True on success, false on error
     */
    public function notify()
    {
        $objMailBox = new Mailbox(
            $this->objObserver->imapPath,
            $this->objObserver->imapLogin,
            \Encryption::decrypt($this->objObserver->imapPassword),
            TL_ROOT . '/' . Files::getPathFromUuid($this->objObserver->attachmentsDir)
        );

        $objMailBox->setConnectionArgs($this->getObserver()->imapOptions ?: 0, $this->objObserver->imapRetriesNum ?: 0, []);

        // Read all messaged into an array:
        $arrMailIds = $objMailBox->searchMailbox($this->getObserver()->imapSearchCriteria);

        if (!$arrMailIds)
        {
            if ($this->getObserver()->debug)
            {
                ObserverLog::add($this->getObserver()->id, 'Mailbox is empty', __CLASS__ . ':' . __METHOD__);
            }

            return;
        }

        // put the newest mails on top
        rsort($arrMailIds);

        if ($this->getObserver()->debug)
        {
            $count = count($arrMailIds);
            ObserverLog::add($this->getObserver()->id, $count . ($count == 1 ? ' Mail' : ' Mails') . ' in Mailbox', __CLASS__ . ':' . __METHOD__);
        }

        foreach ($arrMailIds as $mailId)
        {
            /**  @var \PhpImap\IncomingMail */
            $this->context = $objMailBox->getMail($mailId, false); // do not mark as seen

            if (!$this->waitForContext($this->context, 'date'))
            {
                $this->context = $objMailBox->getMail($mailId, true); // mark as seen

                if ($this->getObserver()->debug)
                {
                    ObserverLog::add($this->getObserver()->id,
                                     'Observers updated with mail: "' . $this->context->subject . '" ' . htmlentities($this->context->messageId)
                                     . '.',
                                     __CLASS__ . ':' . __METHOD__
                    );
                }

                foreach ($this->observers as $obs)
                {
                    $obs->update($this);
                }

                continue;
            }

            if ($this->getObserver()->debug)
            {
                ObserverLog::add($this->getObserver()->id,
                                 'Waiting time for mail: "' . $this->context->subject . '" ' . htmlentities($this->context->messageId)
                                 . ' not elapsed yet.',
                                 __CLASS__ . ':' . __METHOD__
                );
            }

        }

        return true;
    }
}