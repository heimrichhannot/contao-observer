<?php

$GLOBALS['TL_DCA']['tl_observer_log'] = [

    // Config
    'config' => [
        'dataContainer' => 'Table',
        'closed'        => true,
        'ptable'        => 'tl_observer',
        'notEditable'   => true,
        'notCopyable'   => true,
        'sql'           => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],

    // List
    'list'   => [
        'sorting'           => [
            'mode'                  => 4,
            'fields'                => ['tstamp DESC', 'id DESC'],
            'headerFields'          => ['type', 'title', 'tstamp', 'invoked'],
            'panelLayout'           => 'filter;sort,search,limit',
            'child_record_callback' => ['HeimrichHannot\Observer\Backend\ObserverLog', 'colorize'],
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations'        => [
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_observer_log']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_observer_log']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ],
    ],

    // Fields
    'fields' => [
        'id'     => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'pid'    => [
            'foreignKey' => 'tl_observer.title',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'tstamp' => [
            'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['tstamp'],
            'filter' => true,
            'flag'   => 6,
            'sql'    => "int(10) unsigned NOT NULL default '0'",
        ],
        'action' => [
            'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['action'],
            'filter' => true,
            'sql'    => "varchar(32) NOT NULL default ''",
        ],
        'text'   => [
            'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['text'],
            'search' => true,
            'sql'    => "text NULL",
        ],
        'func'   => [
            'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['func'],
            'filter' => true,
            'search' => true,
            'sql'    => "varchar(255) NOT NULL default ''",
        ],
        'type'   => [
            'label' => &$GLOBALS['TL_LANG']['tl_observer_log']['type'],
            'sql'   => "varchar(32) NOT NULL default ''",
        ],
    ],
];
