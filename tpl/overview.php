<?php
use GDO\Links\GDO_Link;
use GDO\Links\Module_Links;
use GDO\Table\GDT_List;
use GDO\Tag\GDT_TagCloud;
use GDO\User\GDO_User;
use GDO\Core\GDT_Fields;

$user = GDO_User::current();

# Render Navtabs
echo Module_Links::instance()->renderTabs()->render();

# Query
$gdo = GDO_Link::table();
$votes = $gdo->gdoVoteTable();
$query = $gdo->select('gdo_link.*, cb.user_name, vote_value as own_vote')->uncached()->
join("LEFT JOIN {$votes->gdoTableIdentifier()} v ON vote_object=link_id AND vote_user={$user->getID()}")->
join("JOIN gdo_user cb ON cb.user_id = gdo_link.link_created_by");

# Cloud
$cloud = GDT_TagCloud::make('cloud')->table($gdo);
$cloud->filterQuery($query);
echo $cloud->render();

# Table
$table = GDT_List::make('links')->listMode(GDT_List::MODE_LIST);
$table->gdo($gdo);
$table->href(href('Links', 'Overview'));
$headers = GDT_Fields::make('s');
$headers->addFields($gdo->getGDOColumns([
    'link_title', 'link_description',
    'link_views', 'link_votes', 'link_rating',
    'link_created_at', 'link_created_by',
]));

$table->headers($headers);
$table->paginateDefault();
$table->filtered();
$table->ordered(true, 'link_rating', false);
$table->searchable();
$table->query($query);
$table->title(t('list_title_links_overview', [$table->countItems()]));
echo $table->render();
