<?php
namespace GDO\Links\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Links\GDO_Link;
use GDO\Links\Module_Links;
use GDO\User\GDO_User;
use GDO\Tag\GDT_Tags;
use GDO\Core\Website;
use GDO\Core\GDT_Response;

final class Add extends MethodForm
{
	public function isUserRequired() { return true; }
	
	/**
	 * @var GDO_Link
	 */
	private $table;
	
	public function init()
	{
	    $this->table = GDO_Link::table();
	}
	
	public function createForm(GDT_Form $form)
	{
		$table = $this->table;
		$module = Module_Links::instance();

		$form->addField(GDT_Tags::make('tags')->tagtable($this->table->gdoTagTable()));
		$form->addField($table->gdoColumn('link_lang')->initial(GDO_LANGUAGE));
		$form->addField($table->gdoColumn('link_title'));
		$form->addField($table->gdoColumn('link_url'));
		if ($module->cfgDescriptions())
		{
			$form->addField($table->gdoColumn('link_description'));
		}
		if ($module->cfgLevels())
		{
			$form->addField($table->gdoColumn('link_level')->initial('0'));
		}
		$form->actions()->addField(GDT_Submit::make());
		$form->addField(GDT_AntiCSRF::make());
	}
	
	public function beforeExecute()
	{
	    Module_Links::instance()->renderTabs();
	}
	
	public function execute()
	{
		$response = GDT_Response::makeWith($this->renderInfoBox());
		if (Module_Links::instance()->cfgAllowed(GDO_User::current()))
		{
			$response->addField(parent::execute());
		}
		return $response;
	}
	
	public function renderInfoBox()
	{
		return $this->templatePHP('add_info.php');
	}
	
	public function formValidated(GDT_Form $form)
	{
	    $link = GDO_Link::blank()->setVars($form->getFormData())->insert();
		$link->updateTags($form->getField('tags')->getValue());
		GDO_Link::recacheCounter();
		$href = href('Links', 'Overview');
		return Website::redirectMessage('msg_link_added', null, $href);
	}
}
