<?php
namespace GDO\Links\Method;

use GDO\Core\MethodCronjob;

final class Cronjob extends MethodCronjob
{
	public function run()
	{
		$this->checkDeadLinks();
	}
	
	private function checkDeadLinks()
	{
		
	}
}
