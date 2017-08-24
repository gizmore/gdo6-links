<?php
use GDO\Links\Link;
use GDO\User\User;
$link instanceof Link;
$user = User::current();
$level = $link->getLevel();
if ($level > $user->getLevel())
{
	l('url_link_level', [$level]);
}
else
{
	$link->edisplay('link_url');
}
