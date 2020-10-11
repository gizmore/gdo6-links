<?php /** @var $link \GDO\Links\GDO_Link **/
use GDO\Links\GDT_LinkTitle;
use GDO\Profile\GDT_ProfileLink;
use GDO\Vote\GDT_VoteSelection;
use GDO\Vote\GDT_VoteRating;
use GDO\UI\GDT_ListItem;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Button;
use GDO\Vote\GDT_VoteCount;
use GDO\UI\GDT_Badge;
$creator = $link->getCreator();

$li = GDT_ListItem::make();
$li->image(GDT_ProfileLink::make()->forUser($creator));
$li->title(GDT_LinkTitle::make()->gdo($link));
$li->subtitle(GDT_Container::make()->addFields([
    GDT_VoteRating::make()->gdo($link), 
    GDT_VoteSelection::make()->gdo($link),
    GDT_VoteCount::make()->gdo($link),
    GDT_Badge::make()->value(t('link_views', [$link->getViews()])),
]));
$li->subtext($link->gdoColumn('link_description'));
$li->actions()->addFields(array(
	GDT_Button::make('btn_view')->disabled(!$link->canView())->href($link->href_visit())->icon('view'),
));

echo $li->render();
