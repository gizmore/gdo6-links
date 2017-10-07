<?php
namespace GDO\Links;

use GDO\Net\GDT_Url;
use GDO\Core\GDT_Template;

final class GDT_LinkUrl extends GDT_Url
{
	public function __construct()
	{
		$this->reachable = true;
		$this->allowLocal = true;
		$this->null = false;
	}
	
// 	public function defaultLabel()
// 	{
// 		return $this->label('title');
// 	}
	
	public function renderCell()
	{
		return GDT_Template::php('Links', 'cell_link_url.php', ['link'=>$this->gdo, 'field'=>$this])->__toString();
	}
}
