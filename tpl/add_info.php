<?php
use GDO\Links\Link;
use GDO\Links\Module_Links;
use GDO\Template\GDO_Box;
use GDO\User\User;

$module = Module_Links::instance();
$links = Link::table();
$user = User::current();
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
echo GDO_Box::make()->html(t('box_content_links_add', $info))->renderCell();
