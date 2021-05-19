<?php
use GDO\Links\GDO_Link;
use GDO\Links\Module_Links;
use GDO\UI\GDT_Panel;
use GDO\User\GDO_User;

$module = Module_Links::instance();
$links = GDO_Link::table();
$user = GDO_User::current();
$total = $links->countWhere("link_deleted_at IS NULL");
$added = $links->countWhere("link_created_by = {$user->getID()} AND link_deleted_at IS NULL");
$link_level = $module->cfgLevels() ? 'link_level' : '0';
$visible = $links->countWhere("link_deleted_at IS NULL AND $link_level <= {$user->getLevel()}");
$info = array(
	$total,
	$added,
	$module->cfgAddPerLevel(),
	$module->cfgAddMin(),
	$total - $visible,
	$user->getLevel(),
	$module->cfgAllowed($user),
);
echo GDT_Panel::make()->text('box_content_links_add', $info)->renderCell();
