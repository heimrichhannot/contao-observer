<?php

use \HeimrichHannot\Observer\ObserverConfig;

$GLOBALS['TL_DCA']['tl_observer'] = array(
	'config'      => array(
		'dataContainer'     => 'Table',
		'enableVersioning'  => true,
		'ctable'            => array('tl_observer_log', 'tl_observer_history'),
		'onload_callback'   => array(
			array('HeimrichHannot\Observer\Backend\ObserverBackend', 'modifyDc'),
		),
		'oncreate_callback' => array(
			array('HeimrichHannot\Observer\Backend\ObserverBackend', 'onCreate'),
		),
		'onsubmit_callback' => array(
			array('HeimrichHannot\Haste\Dca\General', 'setDateAdded'),
		),
		'sql'               => array(
			'keys' => array(
				'id' => 'primary',
			),
		),
	),
	'list'        => array(
		'label'             => array(
			'fields'         => array('title', 'invoke'),
			'format'         => '%s <span style="color:#b3b3b3;padding-right:3px">[%s]</span>',
			'label_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'colorize'),
			'group_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getGroupTitle'),
		),
		'sorting'           => array(
			'mode'        => 2,
			'fields'      => array('subject', 'observer', 'priority DESC', 'title'),
			'panelLayout' => 'filter;search,limit',
		),
		'global_operations' => array(
			'all' => array(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"',
			),
		),
		'operations'        => array(
			'edit'    => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif',
			),
			'copy'    => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif',
			),
			'delete'  => array(
				'label'      => &$GLOBALS['TL_LANG']['tl_observer']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'toggle'  => array(
				'label'           => &$GLOBALS['TL_LANG']['tl_observer']['toggle'],
				'icon'            => 'visible.gif',
				'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback' => array('tl_observer', 'toggleIcon'),
			),
			'log'     => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer']['log'],
				'href'  => 'table=tl_observer_log',
				'icon'  => 'log.gif',
			),
			'history' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer']['history'],
				'href'  => 'table=tl_observer_history',
				'icon'  => 'modules.gif',
			),
			'show'    => array(
				'label' => &$GLOBALS['TL_LANG']['tl_observer']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif',
			),
		),
	),
	'palettes'    => array(
		'__selector__'                        => array('subject', 'useCronExpression', 'action', 'limitMembers', 'addObserverStates', 'published'),
		'default'                             => '{general_legend},subject;{publish_legend},published;',
		ObserverConfig::OBSERVER_SUBJECT_MAIl => '{general_legend},subject,title;{mailbox_legend},imapPath,imapLogin,imapPassword,imapOptions,imapRetriesNum,attachmentsDir,expungeOnDisconnect,imapSearchCriteria;{cronjob_legend},cronInterval,useCronExpression,priority,invoked,invokedState;{observer_legend},observer;{expert_legend},debug,addObserverStates;{publish_legend},published;',
	),
	'subpalettes' => array(
		'useCronExpression' => 'cronExpression',
		'addObserverStates' => 'observerStates',
		'limitMembers'      => 'memberGroupMembers',
		'published'         => 'start,stop',
	),
	'fields'      => array(
		'id'                  => array(
			'sql' => "int(10) unsigned NOT NULL auto_increment",
		),
		'tstamp'              => array(
			'label' => &$GLOBALS['TL_LANG']['tl_observer']['tstamp'],
			'sql'   => "int(10) unsigned NOT NULL default '0'",
		),
		'dateAdded'           => array(
			'label'   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'sorting' => true,
			'flag'    => 6,
			'eval'    => array('rgxp' => 'datim', 'doNotCopy' => true),
			'sql'     => "int(10) unsigned NOT NULL default '0'",
		),
		'title'               => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['title'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'flag'      => 1,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'tl_class' => 'w50'),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'subject'             => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['subject'],
			'exclude'          => true,
			'filter'           => true,
			'flag'             => 11,
			'inputType'        => 'select',
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getSubjects'),
			'reference'        => &$GLOBALS['TL_LANG']['OBSERVER_SUBJECT'],
			'eval'             => array('includeBlankOption' => true, 'chosen' => true, 'submitOnChange' => true, 'mandatory' => true),
			'sql'              => "varchar(64) NOT NULL default ''",
		),
		'imapPath'            => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapPath'],
			'exclude'   => true,
			'default'   => '{imap.gmail.com:993/imap/ssl}INBOX',
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'tl_class' => 'long', 'maxlength' => 128),
			'sql'       => "varchar(128) NOT NULL default ''",
		),
		'imapLogin'           => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapLogin'],
			'exclude'   => true,
			'default'   => 'some@gmail.com',
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'tl_class' => 'w50', 'maxlength' => 128),
			'sql'       => "varchar(128) NOT NULL default ''",
		),
		'imapPassword'        => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapPassword'],
			'exclude'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'tl_class' => 'w50', 'encrypt' => true),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'imapOptions'         => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapOptions'],
			'exclude'   => true,
			'inputType' => 'checkboxWizard',
			'options'   => array(OP_READONLY, OP_ANONYMOUS, OP_HALFOPEN, CL_EXPUNGE, OP_DEBUG, OP_SHORTCACHE, OP_SILENT, OP_PROTOTYPE, OP_SECURE),
			'reference' => &$GLOBALS['TL_LANG']['MSC']['imapOptions'],
			'eval'      => array('multiple' => true, 'tl_class' => 'wizard clr', 'maxlength' => 128),
			'sql'       => "blob NULL",
		),
		'imapRetriesNum'      => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['imapRetriesNum'],
			'exclude'   => true,
			'default'   => 0,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'digit'),
			'sql'       => "int(10) unsigned NOT NULL default '0'",
		),
		'attachmentsDir'      => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_observer']['attachmentsDir'],
			'exclude'       => true,
			'inputType'     => 'fileTree',
			'save_callback' => array(
				array('HeimrichHannot\Observer\Backend\ObserverBackend', 'setAttachmentsDir'),
			),
			'eval'          => array('filesOnly' => false, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'),
			'sql'           => "binary(16) NULL",
		),
		'expungeOnDisconnect' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['expungeOnDisconnect'],
			'exclude'   => true,
			'default'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('tl_class' => 'w50'),
			'sql'       => "char(1) NOT NULL default '1'",
		),
		'imapSearchCriteria'  => array(
			'label'       => &$GLOBALS['TL_LANG']['tl_observer']['imapSearchCriteria'],
			'exclude'     => true,
			'default'     => 'ALL',
			'inputType'   => 'text',
			'explanation' => 'imapSearchCriteria',
			'eval'        => array('helpwizard' => true, 'tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true),
			'sql'         => "varchar(255) NOT NULL default 'ALL'",
		),
		'priority'            => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['priority'],
			'exclude'   => true,
			'default'   => 0,
			'inputType' => 'text',
			'eval'      => array('rgxp' => 'natural', 'tl_class' => 'w50', 'maxlength' => 3, 'mandatory' => true),
			'sql'       => "int(1) NOT NULL default '0'",
		),
		'cronInterval'        => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['cronInterval'],
			'exclude'          => true,
			'inputType'        => 'select',
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getCronIntervals'),
			'reference'        => &$GLOBALS['TL_LANG']['MSC']['cronInterval'],
			'eval'             => array('tl_class' => 'w50', 'includeBlankOption' => true),
			'sql'              => "varchar(12) NOT NULL default ''",
		),
		'useCronExpression'   => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['useCronExpression'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('doNotCopy' => true, 'submitOnChange' => true, 'tl_class' => 'clr'),
			'sql'       => "char(1) NOT NULL default ''",
		),
		'cronExpression'      => array(
			'label'       => &$GLOBALS['TL_LANG']['tl_observer']['cronExpression'],
			'exclude'     => true,
			'inputType'   => 'text',
			'explanation' => 'cronExpression',
			'eval'        => array('helpwizard' => true, 'tl_class' => 'w50', 'maxlength' => 64, 'mandatory' => true),
			'sql'         => "varchar(64) NOT NULL default ''",
		),
		'debug'               => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['debug'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('doNotCopy' => true),
			'sql'       => "char(1) NOT NULL default ''",
		),
		'invoked'             => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['invoked'],
			'exclude'   => true,
			'inputType' => 'text',
			'eval'      => array('rgxp' => 'datim', 'readonly' => 'true', 'tl_class' => 'clr w50', 'doNotCopy' => true),
			'sql'       => "varchar(10) NOT NULL default ''",
		),
		'invokedState'        => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['invokedState'],
			'exclude'   => true,
			'inputType' => 'text',
			'eval'      => array('tl_class' => 'w50', 'includeBlankOption' => true, 'readonly' => true, 'doNotCopy' => true),
			'sql'       => "varchar(64) NOT NULL default ''",
		),
		'observer'            => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['observer'],
			'exclude'          => true,
			'filter'           => true,
			'flag'             => 11,
			'inputType'        => 'select',
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getObservers'),
			'reference'        => &$GLOBALS['TL_LANG']['OBSERVER_OBSERVER'],
			'eval'             => array('includeBlankOption' => true, 'chosen' => true, 'submitOnChange' => true, 'tl_class' => 'w50'),
			'sql'              => "varchar(64) NOT NULL default ''",
		),
		'addObserverStates'   => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['addObserverStates'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('doNotCopy' => true, 'submitOnChange' => true, 'tl_class' => 'clr w50'),
			'sql'       => "char(1) NOT NULL default ''",
		),
		'observerStates'      => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['observerStates'],
			'exclude'          => true,
			'inputType'        => 'checkboxWizard',
			'default'          => array(\HeimrichHannot\Observer\Observer::STATE_SUCCESS),
			'reference'        => $GLOBALS['TL_LANG']['OBSERVER_STATES'],
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getObserverStates'),
			'eval'             => array('tl_class' => 'clr wizard', 'maxlength' => 255, 'multiple' => true, 'mandatory' => true),
			'sql'              => "blob NULL",
		),
		'notification'        => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['notification'],
			'exclude'          => true,
			'inputType'        => 'select',
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getNotifications'),
			'eval'             => array('tl_class' => 'clr', 'mandatory' => true, 'includeBlankOption' => true),
			'sql'              => "int(10) unsigned NOT NULL default '0'",
		),
		'members'             => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['members'],
			'exclude'   => true,
			'inputType' => 'tagsinput',
			'eval'      => array(
				'tl_class'    => 'clr',
				'multiple'    => true,
				'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['members'],
				'mode'        => \TagsInput::MODE_REMOTE,
				'remote'      => array(
					'fields'       => array('lastname', 'firstname', 'id'),
					'format'       => '%s %s [ID:%s]',
					'queryField'   => 'lastname',
					'queryPattern' => '%QUERY%',
					'foreignKey'   => 'tl_member.id',
					'limit'        => 10,
				),
			),
			'sql'       => "blob NULL",
		),
		'memberGroups'        => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['memberGroups'],
			'exclude'   => true,
			'inputType' => 'tagsinput',
			'eval'      => array(
				'tl_class'    => 'clr',
				'multiple'    => true,
				'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['members'],
				'mode'        => \TagsInput::MODE_REMOTE,
				'remote'      => array(
					'fields'       => array('name', 'id'),
					'format'       => '%s [ID:%s]',
					'queryField'   => 'name',
					'queryPattern' => '%QUERY%',
					'foreignKey'   => 'tl_member_group.id',
					'limit'        => 10,
				),
			),
			'sql'       => "blob NULL",
		),
		'limitMembers'        => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['limitMembers'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('doNotCopy' => true, 'submitOnChange' => true),
			'sql'       => "char(1) NOT NULL default ''",
		),
		'memberGroupMembers'  => array(
			'label'            => &$GLOBALS['TL_LANG']['tl_observer']['memberGroupMembers'],
			'exclude'          => true,
			'inputType'        => 'tagsinput',
			'options_callback' => array('HeimrichHannot\Observer\Backend\ObserverBackend', 'getMemberGroupMembers'),
			'eval'             => array(
				'mandatory'   => true,
				'placeholder' => &$GLOBALS['TL_LANG']['tl_observer']['placeholder']['memberGroupMembers'],
				'tl_class'    => 'clr',
				'multiple'    => true,
				'mode'        => \TagsInput::MODE_REMOTE,
				'remote'      => array(
					'queryPattern' => '%QUERY%',
					'limit'        => 10,
				),
			),
			'sql'              => "blob NULL",
		),
		'published'           => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['published'],
			'exclude'   => true,
			'filter'    => true,
			'inputType' => 'checkbox',
			'eval'      => array('doNotCopy' => true, 'submitOnChange' => true),
			'sql'       => "char(1) NOT NULL default ''",
		),
		'start'               => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['start'],
			'exclude'   => true,
			'inputType' => 'text',
			'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
			'sql'       => "varchar(10) NOT NULL default ''",
		),
		'stop'                => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_observer']['stop'],
			'exclude'   => true,
			'inputType' => 'text',
			'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
			'sql'       => "varchar(10) NOT NULL default ''",
		),
	),
);


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

		return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ';
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
