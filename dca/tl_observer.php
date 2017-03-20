<?php

use \HeimrichHannot\Observer\ObserverConfig;

$GLOBALS['TL_DCA']['tl_observer'] = [
    'config'      => [
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
        'ctable'            => ['tl_observer_log', 'tl_observer_history'],
        'onload_callback'   => [
            ['HeimrichHannot\Observer\Backend\Observer', 'modifyDc'],
        ],
        'oncreate_callback' => [
            ['HeimrichHannot\Observer\Backend\Observer', 'onCreate'],
        ],
        'onsubmit_callback' => [
            ['HeimrichHannot\Haste\Dca\General', 'setDateAdded'],
        ],
        'sql'               => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list'        => [
        'label'             => [
            'fields'         => ['title', 'invoke'],
            'format'         => '%s <span style="color:#b3b3b3;padding-right:3px">[%s]</span>',
            'label_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'colorize'],
            'group_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getGroupTitle'],
        ],
        'sorting'           => [
            'mode'        => 2,
            'fields'      => ['observer', 'priority DESC', 'title'],
            'panelLayout' => 'filter;search,limit',
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ],
        ],
        'operations'        => [
            'edit'    => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ],
            'copy'    => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete'  => [
                'label'      => &$GLOBALS['TL_LANG']['tl_observer']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"',
            ],
            'toggle'  => [
                'label'           => &$GLOBALS['TL_LANG']['tl_observer']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['tl_observer', 'toggleIcon'],
            ],
            'log'     => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer']['log'],
                'href'  => 'table=tl_observer_log',
                'icon'  => 'log.gif',
            ],
            'history' => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer']['history'],
                'href'  => 'table=tl_observer_history',
                'icon'  => 'system/modules/observer/assets/img/icon-history.png',
            ],
            'show'    => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ],
    ],
    'palettes'    => [
        '__selector__'                        => [
            'subject',
            'addContextAge',
            'useCronExpression',
            'action',
            'limitMembers',
            'addObserverStates',
            'published'
        ],
        'default'                             => '{general_legend},subject;{publish_legend},published;',
        ObserverConfig::OBSERVER_SUBJECT_MAIL => '{general_legend},subject,title;{mailbox_legend},imapPath,imapLogin,imapPassword,imapOptions,imapRetriesNum,attachmentsDir,expungeOnDisconnect,imapSearchCriteria,addContextAge;{cronjob_legend},cronInterval,useCronExpression,priority,invoked,invokedState;{observer_legend},observer;{expert_legend},debug,addObserverStates;{publish_legend},published;',
    ],
    'subpalettes' => [
        'addContextAge'     => 'contextAgeAttribute, contextAge',
        'useCronExpression' => 'cronExpression',
        'addObserverStates' => 'observerStates',
        'limitMembers'      => 'memberGroupMembers',
        'published'         => 'start,stop',
    ],
    'fields'      => [
        'id'                  => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp'              => [
            'label' => &$GLOBALS['TL_LANG']['tl_observer']['tstamp'],
            'sql'   => "int(10) unsigned NOT NULL default '0'",
        ],
        'dateAdded'           => [
            'label'   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'sorting' => true,
            'flag'    => 6,
            'eval'    => ['rgxp' => 'datim', 'doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
        'title'               => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['title'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'subject'             => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['subject'],
            'exclude'          => true,
            'filter'           => true,
            'flag'             => 11,
            'inputType'        => 'select',
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getSubjects'],
            'reference'        => &$GLOBALS['TL_LANG']['OBSERVER_SUBJECT'],
            'eval'             => ['includeBlankOption' => true, 'chosen' => true, 'submitOnChange' => true, 'mandatory' => true],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'addContextAge'       => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['addContextAge'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'clr', 'submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'contextAgeAttribute' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['contextAgeAttribute'],
            'exclude'   => true,
            'default'   => 'tstamp',
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default 'tstamp'",
        ],
        'contextAge'          => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['contextAge'],
            'exclude'   => true,
            'default'   => 300,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'digit'],
            'sql'       => "varchar(10) NOT NULL default '300'",
        ],
        'imapPath'            => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapPath'],
            'exclude'   => true,
            'default'   => '{imap.gmail.com:993/imap/ssl}INBOX',
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'long', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],
        'imapLogin'           => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapLogin'],
            'exclude'   => true,
            'default'   => 'some@gmail.com',
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],
        'imapPassword'        => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapPassword'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'encrypt' => true],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'imapOptions'         => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapOptions'],
            'exclude'   => true,
            'inputType' => 'checkboxWizard',
            'options'   => [OP_READONLY, OP_ANONYMOUS, OP_HALFOPEN, CL_EXPUNGE, OP_DEBUG, OP_SHORTCACHE, OP_SILENT, OP_PROTOTYPE, OP_SECURE],
            'reference' => &$GLOBALS['TL_LANG']['MSC']['imapOptions'],
            'eval'      => ['multiple' => true, 'tl_class' => 'wizard clr', 'maxlength' => 128],
            'sql'       => "blob NULL",
        ],
        'imapRetriesNum'      => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapRetriesNum'],
            'exclude'   => true,
            'default'   => 0,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'digit'],
            'sql'       => "int(10) unsigned NOT NULL default '0'",
        ],
        'attachmentsDir'      => [
            'label'         => &$GLOBALS['TL_LANG']['tl_observer']['attachmentsDir'],
            'exclude'       => true,
            'inputType'     => 'fileTree',
            'save_callback' => [
                ['HeimrichHannot\Observer\Backend\Observer', 'setAttachmentsDir'],
            ],
            'eval'          => ['filesOnly' => false, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
            'sql'           => "binary(16) NULL",
        ],
        'expungeOnDisconnect' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['expungeOnDisconnect'],
            'exclude'   => true,
            'default'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50'],
            'sql'       => "char(1) NOT NULL default '1'",
        ],
        'imapSearchCriteria'  => [
            'label'       => &$GLOBALS['TL_LANG']['tl_observer']['imapSearchCriteria'],
            'exclude'     => true,
            'default'     => 'ALL',
            'inputType'   => 'text',
            'explanation' => 'imapSearchCriteria',
            'eval'        => ['helpwizard' => true, 'tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true],
            'sql'         => "varchar(255) NOT NULL default 'ALL'",
        ],
        'priority'            => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['priority'],
            'exclude'   => true,
            'default'   => 0,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'natural', 'tl_class' => 'w50', 'maxlength' => 3, 'mandatory' => true],
            'sql'       => "int(1) NOT NULL default '0'",
        ],
        'cronInterval'        => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['cronInterval'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getCronIntervals'],
            'reference'        => &$GLOBALS['TL_LANG']['MSC']['cronInterval'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true],
            'sql'              => "varchar(12) NOT NULL default ''",
        ],
        'useCronExpression'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['useCronExpression'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true, 'submitOnChange' => true, 'tl_class' => 'clr'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'cronExpression'      => [
            'label'       => &$GLOBALS['TL_LANG']['tl_observer']['cronExpression'],
            'exclude'     => true,
            'inputType'   => 'text',
            'explanation' => 'cronExpression',
            'eval'        => ['helpwizard' => true, 'tl_class' => 'w50', 'maxlength' => 64, 'mandatory' => true],
            'sql'         => "varchar(64) NOT NULL default ''",
        ],
        'debug'               => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['debug'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'invoked'             => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['invoked'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'datim', 'readonly' => 'true', 'tl_class' => 'clr w50', 'doNotCopy' => true],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],
        'invokedState'        => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['invokedState'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => true, 'readonly' => true, 'doNotCopy' => true],
            'sql'       => "varchar(64) NOT NULL default ''",
        ],
        'observer'            => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['observer'],
            'exclude'          => true,
            'filter'           => true,
            'flag'             => 11,
            'inputType'        => 'select',
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getObservers'],
            'reference'        => &$GLOBALS['TL_LANG']['OBSERVER_OBSERVER'],
            'eval'             => ['includeBlankOption' => true, 'chosen' => true, 'submitOnChange' => true, 'mandatory' => true, 'tl_class' => 'w50'],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'addObserverStates'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['addObserverStates'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true, 'submitOnChange' => true, 'tl_class' => 'clr w50'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'observerStates'      => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['observerStates'],
            'exclude'          => true,
            'inputType'        => 'checkboxWizard',
            'default'          => [\HeimrichHannot\Observer\Observer::STATE_SUCCESS],
            'reference'        => $GLOBALS['TL_LANG']['OBSERVER_STATES'],
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getObserverStates'],
            'eval'             => ['tl_class' => 'clr wizard', 'maxlength' => 255, 'multiple' => true, 'mandatory' => true],
            'sql'              => "blob NULL",
        ],
        'notification'        => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['notification'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getNotifications'],
            'eval'             => ['tl_class' => 'clr', 'mandatory' => true, 'includeBlankOption' => true],
            'sql'              => "int(10) unsigned NOT NULL default '0'",
        ],
        'members'             => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['members'],
            'exclude'   => true,
            'inputType' => 'tagsinput',
            'eval'      => [
                'tl_class'    => 'clr',
                'multiple'    => true,
                'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['members'],
                'mode'        => \TagsInput::MODE_REMOTE,
                'remote'      => [
                    'fields'       => ['lastname', 'firstname', 'id'],
                    'format'       => '%s %s [ID:%s]',
                    'queryField'   => 'lastname',
                    'queryPattern' => '%QUERY%',
                    'foreignKey'   => 'tl_member.id',
                    'limit'        => 10,
                ],
            ],
            'sql'       => "blob NULL",
        ],
        'memberGroups'        => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['memberGroups'],
            'exclude'   => true,
            'inputType' => 'tagsinput',
            'eval'      => [
                'tl_class'    => 'clr',
                'multiple'    => true,
                'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['members'],
                'mode'        => \TagsInput::MODE_REMOTE,
                'remote'      => [
                    'fields'       => ['name', 'id'],
                    'format'       => '%s [ID:%s]',
                    'queryField'   => 'name',
                    'queryPattern' => '%QUERY%',
                    'foreignKey'   => 'tl_member_group.id',
                    'limit'        => 10,
                ],
            ],
            'sql'       => "blob NULL",
        ],
        'limitMembers'        => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['limitMembers'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true, 'submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'memberGroupMembers'  => [
            'label'            => &$GLOBALS['TL_LANG']['tl_observer']['memberGroupMembers'],
            'exclude'          => true,
            'inputType'        => 'tagsinput',
            'options_callback' => ['HeimrichHannot\Observer\Backend\Observer', 'getMemberGroupMembers'],
            'eval'             => [
                'mandatory'   => true,
                'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['memberGroupMembers'],
                'tl_class'    => 'clr',
                'multiple'    => true,
                'mode'        => \TagsInput::MODE_REMOTE,
                'remote'      => [
                    'queryPattern' => '%QUERY%',
                    'limit'        => 10,
                ],
            ],
            'sql'              => "blob NULL",
        ],
        'published'           => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['published'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true, 'submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'start'               => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['start'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],
        'stop'                => [
            'label'     => &$GLOBALS['TL_LANG']['tl_observer']['stop'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],
    ],
];


class tl_observer extends \Backend
{

    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        $objUser = \BackendUser::getInstance();

        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            \Controller::redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$objUser->isAdmin && !$objUser->hasAccess('tl_observer::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label)
               . '</a> ';
    }

    public function toggleVisibility($intId, $blnVisible)
    {
        $objUser     = \BackendUser::getInstance();
        $objDatabase = \Database::getInstance();

        // Check permissions to publish
        if (!$objUser->isAdmin && !$objUser->hasAccess('tl_observer::published', 'alexf'))
        {
            \Controller::log('Not enough permissions to publish/unpublish item ID "' . $intId . '"', 'tl_observer toggleVisibility', TL_ERROR);
            \Controller::redirect('contao/main.php?act=error');
        }

        $objVersions = new Versions('tl_observer', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_observer']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_observer']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $objDatabase->prepare("UPDATE tl_observer SET tstamp=" . time() . ", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")->execute($intId);

        $objVersions->create();
        \Controller::log(
            'A new version of record "tl_observer.id=' . $intId . '" has been created' . $this->getParentEntries('tl_observer', $intId),
            'tl_observer toggleVisibility()',
            TL_GENERAL
        );
    }

}
