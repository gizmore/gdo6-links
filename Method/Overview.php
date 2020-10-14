<?php
namespace GDO\Links\Method;

use GDO\Core\Method;

final class Overview extends Method
{
	public function execute()
	{
		return $this->templatePHP('overview.php');
	}
	
}
