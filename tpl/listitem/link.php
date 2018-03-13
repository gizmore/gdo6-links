<?php /** @var $link \GDO\Links\GDO_Link **/
use GDO\Date\Time;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Menu;
use GDO\User\GDO_User;
use GDO\Links\GDT_LinkTitle;
use GDO\Profile\GDT_ProfileLink;
use GDO\Vote\GDT_VoteSelection;
use GDO\Vote\GDT_VoteRating;
$creator = $link->getCreator();
$user = GDO_User::current();
$username = $creator->displayNameLabel();
$date = $link->getCreated();
$age = Time::displayAge($date);
$views = $link->getViews();
$votes = $link->getVoteCount();
$rating = $link->getVoteRating(); ?>
<div class="gdt-list-item">
  <div><?=GDT_ProfileLink::make()->forUser($creator)->render()?></div>
  <div class="gdt-content">
    <h3><?=GDT_LinkTitle::make()->gdo($link)->render()?></h3>
    <h4>
      <?=GDT_VoteRating::make()->gdo($link)->render()?>
      <?=GDT_VoteSelection::make()->gdo($link)->renderForm()?>
    </h4>
    <p><?=$link->display('link_description')?></p>
  </div>
  <div class="gdt-actions">
<?php
$menu = GDT_Menu::make();
$menu->addField(GDT_Link::make('link_view')->href($link->href_visit()));
echo $menu->render();
?>
  </div>
</div>
