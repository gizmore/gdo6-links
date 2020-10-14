<?php
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
/** @var $link GDO_Link **/
$user = GDO_User::current();
$level = $link->getLevel();
if ($level > $user->getLevel())
{
	echo t('title_link_level', [$level]);
}
else
{
	echo html($link->getVar('link_title'));
}
