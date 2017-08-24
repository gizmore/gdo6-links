<?php
namespace GDO\Links\Method;
use GDO\Core\Method;
use GDO\Core\Website;
use GDO\Links\Link;
use GDO\User\User;
use GDO\Util\Common;
/**
 * Increase visit counter and redirect.
 * @author gizmore
 */
final class Visit extends Method
{
	public function execute()
	{
		$link = Link::table()->find(Common::getRequestInt('id'));
		$user = User::current();
		$level = $link->getLevel();
		if ($level > $user->getLevel())
		{
			return $this->error('err_link_level', [$level]);
		}
		
		$link->increase('link_views');
		
		return Website::redirect($link->getURL());
	}
}
