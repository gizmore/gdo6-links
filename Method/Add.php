<?php
namespace GDO\Links\Method;

use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;
use GDO\Links\Link;
use GDO\Links\Module_Links;
use GDO\User\User;
use GDO\Tag\GDO_Tag;

final class Add extends MethodForm
{
	public function isUserRequired() { return true; }
	
	/**
	 * @var Link
	 */
	private $table;
	
	public function init()
	{
		$this->table = Link::table();
	}
	
	public function createForm(GDO_Form $form)
	{
		$table = $this->table;
		$module = Module_Links::instance();

		$form->addField(GDO_Tag::make('tags'));
		$form->addField($table->gdoColumn('link_lang'));
		$form->addField($table->gdoColumn('link_title'));
		$form->addField($table->gdoColumn('link_url'));
		if ($module->cfgDescriptions())
		{
			$form->addField($table->gdoColumn('link_description'));
		}
		if ($module->cfgLevels())
		{
			$form->addField($table->gdoColumn('link_level'));
		}
		$form->addField(GDO_Submit::make());
		$form->addField(GDO_AntiCSRF::make());
	}
	
	public function execute()
	{
		$response = Module_Links::instance()->renderTabs()->add($this->renderInfoBox());
		if ($allowed = Module_Links::instance()->cfgAllowed(User::current()))
		{
			$response->add(parent::execute());
		}
		return $response;
	}
	
	public function renderInfoBox()
	{
		return $this->templatePHP('add_info.php');
	}
	
	public function formValidated(GDO_Form $form)
	{
		$link = Link::blank()->setVars($form->getFormData())->insert();
		
		$link->updateTags($form->getField('tags')->getValue());
		
		return $this->message('msg_link_added')->add($this->execMethod('Overview'));
	}
}
