<?php
namespace GDO\Links;

use GDO\Core\GDT_Template;
use GDO\UI\GDT_Message;

/**
 * Display the title of a link, or the censored message.
 * A link title has a minlength of 3. 
 * @author gizmore
 */
final class GDT_LinkDescription extends GDT_Message
{
	public function defaultLabel() { return $this->label('description'); }

	protected function __construct()
	{
// 	    parent::__construct();
		$this->min = 3;
		$this->max = 512;
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Links', 'cell_link_description.php', ['link'=>$this->gdo, 'field'=>$this]);
	}

}
