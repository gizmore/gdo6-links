<?php
use GDO\Links\GDO_Link;
use GDO\Links\Module_Links;
use GDO\Table\GDT_List;
use GDO\Tag\GDT_TagCloud;
use GDO\UI\GDT_Button;
use GDO\User\GDO_User;
use GDO\Vote\GDT_VoteSelection;

$user = GDO_User::current();

# Render Navtabs
echo Module_Links::instance()->renderTabs();

# Query
$gdo = GDO_Link::table();
$votes = $gdo->gdoVoteTable();
$query = $gdo->select('gdo_link.*, vote_value as own_vote')->uncached()->join("LEFT JOIN {$votes->gdoTableIdentifier()} v ON vote_object=link_id AND vote_user={$user->getID()}");

# Cloud
$cloud = GDT_TagCloud::make('cloud')->table($gdo);
$cloud->filterQuery($query);
echo $cloud->render();

# Table
$table = GDT_List::make('links')->listMode(GDT_List::MODE_LIST);
$table->gdo($gdo);
$table->href(href('Links', 'Overview'));
$table->addFields($gdo->getGDOColumns(['link_id', 'link_title', 'link_views', 'link_url', 'link_votes', 'link_rating']));
$table->addField(GDT_VoteSelection::make('link_vote'));
$table->addField(GDT_Button::make('visit'));
$table->paginateDefault();
$table->filtered();
$table->ordered();
$table->query($query);
$table->label('list_title_links_overview', [sitename(), $table->countItems()]);
echo $table->renderCell();
