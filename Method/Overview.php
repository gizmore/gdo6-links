<?php
namespace GDO\Links\Method;

use GDO\Links\Module_Links;
use GDO\UI\MethodPage;
use GDO\UI\GDT_Page;

final class Overview extends MethodPage
{
    public function beforeExecute()
    {
         Module_Links::instance()->renderTabs();
    }
    
    
// 	public function execute()
// 	{
// 		return $this->php('overview.php');
// 	}
	
}
