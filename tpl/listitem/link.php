<?php /** @var $link \GDO\Links\GDO_Link **/
use GDO\Date\Time;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Menu;
use GDO\User\GDO_User;
use GDO\Links\GDT_LinkTitle;
use GDO\Profile\GDT_ProfileLink;
use GDO\Vote\GDT_VoteSelection;
use GDO\Vote\GDT_VoteRating;
use GDO\UI\GDT_ListItem;
use GDO\UI\GDT_Headline;
use GDO\UI\WithHTML;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Button;
$creator = $link->getCreator();
$user = GDO_User::current();
$username = $creator->displayNameLabel();
$date = $link->getCreated();
$age = Time::displayAge($date);
$views = $link->getViews();
$votes = $link->getVoteCount();
$rating = $link->getVoteRating();

$li = GDT_ListItem::make();
$li->image(GDT_ProfileLink::make()->forUser($creator));
$li->title(GDT_LinkTitle::make()->gdo($link));
$li->subtitle(GDT_Container::make()->addFields([GDT_VoteRating::make()->gdo($link), GDT_VoteSelection::make()->gdo($link)]));
$li->subtext($link->gdoColumn('link_description'));
$li->actions()->addFields(array(
	GDT_Button::make('btn_view')->href($link->href_visit())->icon('view'),
));

echo $li->render();
