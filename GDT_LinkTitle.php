<?php
namespace GDO\Links;

use GDO\Template\GDT_Template;
use GDO\Type\GDT_String;

final class GDT_LinkTitle extends GDT_String
{
	public function __construct()
	{
		$this->min = 3;
		$this->max = 128;
		$this->null = false;
	}
	
	public function defaultLabel()
	{
		return $this->label('title');
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Links', 'cell_link_title.php', ['link'=>$this->gdo, 'field'=>$this])->__toString();
	}
}