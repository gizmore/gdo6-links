<?php
namespace GDO\Links;

use GDO\Template\GDO_Template;
use GDO\Type\GDO_String;

final class GDO_LinkTitle extends GDO_String
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
		return GDO_Template::php('Links', 'cell_link_title.php', ['link'=>$this->gdo, 'field'=>$this])->__toString();
	}
}
