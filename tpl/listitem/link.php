<?php /** @var $link \GDO\Links\GDO_Link **/
use GDO\Vote\GDT_VoteSelection;
use GDO\Vote\GDT_VoteRating;
use GDO\UI\GDT_ListItem;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Button;
use GDO\Vote\GDT_VoteCount;
use GDO\UI\GDT_Badge;

$li = GDT_ListItem::make()->gdo($link);

$li->titleCreation($link->gdoColumn('link_title'));
$li->content($link->gdoColumn('link_description'));

$li->subtext(GDT_Container::make()->addFields([
    GDT_VoteRating::make()->gdo($link), 
    GDT_VoteSelection::make()->gdo($link),
    GDT_VoteCount::make()->gdo($link),
    GDT_Badge::make()->value(t('link_views', [$link->getViews()])),
]));

$li->actions()->addFields(array(
	GDT_Button::make('btn_view')->disabled(!$link->canView())->href($link->href_visit())->icon('view'),
));

echo $li->render();
