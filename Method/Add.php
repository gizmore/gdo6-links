<?php
namespace GDO\Links\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Links\Link;
use GDO\Links\Module_Links;
use GDO\User\User;
use GDO\Tag\GDT_Tag;
use GDO\Tag\GDT_Tags;

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
	
	public function createForm(GDT_Form $form)
	{
		$table = $this->table;
		$module = Module_Links::instance();

		$form->addField(GDT_Tags::make('tags'));
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
		$form->addField(GDT_Submit::make());
		$form->addField(GDT_AntiCSRF::make());
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
	
	public function formValidated(GDT_Form $form)
	{
		$link = Link::blank()->setVars($form->getFormData())->insert();
		$link->updateTags($form->getField('tags')->getValue());
		
		return $this->message('msg_link_added')->add($this->execMethod('Overview'));
	}
}
