<?php

$GLOBALS['TL_DCA']['tl_observer_log'] = array(

	// Config
	'config' => array(
		'dataContainer' => 'Table',
		'closed'        => true,
		'ptable'        => 'tl_observer',
		'notEditable'   => true,
		'notCopyable'   => true,
		'sql'           => array(
			'keys' => array(
				'id' => 'primary',
			),
		),
	),

	// List
	'list'   => array(
		'sorting'           => array(
			'mode'                  => 4,
			'fields'                => array('tstamp DESC', 'id DESC'),
			'headerFields'          => array('type', 'title', 'tstamp', 'invoked'),
			'panelLayout'           => 'filter;sort,search,limit',
			'child_record_callback' => array('HeimrichHannot\Observer\Backend\ObserverLogBackend', 'colorize'),
		),
		'global_operations' => array(
			'all' => array(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
			),
		),
		'operations'        => array(
			'delete' => array(
				'label'      => &$GLOBALS['TL_LANG']['tl_observer_log']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
								. '\'))return false;Backend.getScrollOffset()"',
			),
			'show'   => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer_log']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif',
			),
		),
	),

	// Fields
	'fields' => array(
		'id'     => array(
			'sql' => "int(10) unsigned NOT NULL auto_increment",
		),
		'pid'    => array(
			'foreignKey' => 'tl_observer.title',
			'sql'        => "int(10) unsigned NOT NULL default '0'",
			'relation'   => array('type' => 'belongsTo', 'load' => 'eager'),
		),
		'tstamp' => array(
			'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['tstamp'],
			'filter' => true,
			'flag'   => 6,
			'sql'    => "int(10) unsigned NOT NULL default '0'",
		),
		'action' => array(
			'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['action'],
			'filter' => true,
			'sql'    => "varchar(32) NOT NULL default ''",
		),
		'text'   => array(
			'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['text'],
			'search' => true,
			'sql'    => "text NULL",
		),
		'func'   => array(
			'label'  => &$GLOBALS['TL_LANG']['tl_observer_log']['func'],
			'filter' => true,
			'search' => true,
			'sql'    => "varchar(255) NOT NULL default ''",
		),
		'type'   => array(
			'label' => &$GLOBALS['TL_LANG']['tl_observer_log']['type'],
			'sql'   => "varchar(32) NOT NULL default ''",
		),
	),
);
