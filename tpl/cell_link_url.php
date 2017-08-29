<?php
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
$link instanceof GDO_Link;
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
