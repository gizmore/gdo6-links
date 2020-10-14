<?php
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
/** @var $link GDO_Link **/
$user = GDO_User::current();
$level = $link->getLevel();
if ($level > $user->getLevel())
{
	l('url_link_level', [$level]);
}
else
{
	$link->edisplay('link_url');
}
