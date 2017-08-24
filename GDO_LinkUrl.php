<?php
namespace GDO\Links;

use GDO\Net\GDO_Url;
use GDO\Template\GDO_Template;

final class GDO_LinkUrl extends GDO_Url
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
		return GDO_Template::php('Links', 'cell_link_url.php', ['link'=>$this->gdo, 'field'=>$this])->__toString();
	}
}
