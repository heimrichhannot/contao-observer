<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\Observer\Command;


use Contao\CoreBundle\Command\AbstractLockedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ManagerCommand extends AbstractLockedCommand
{
    protected function configure()
    {
        $this->setName('huh:observer:manager:run')
            ->setDescription('Run the observer manager.');
    }


    protected function executeLocked(InputInterface $input, OutputInterface $output)
    {
        $framework = $this->getContainer()->get('contao.framework');
        $framework->initialize();

        $manager = $GLOBALS['OBSERVER']['MANAGER'];
        $manager->run();
    }

}