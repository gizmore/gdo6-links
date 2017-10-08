<?php /** @var $link \GDO\Links\GDO_Link **/
use GDO\Date\Time;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\Links\GDT_LinkTitle;
use GDO\Avatar\GDO_Avatar;
use GDO\User\GDT_LevelPopup;
use GDO\Vote\GDT_VotePopup;

$creator = $link->getCreator();
$user = GDO_User::current();
$username = $creator->displayNameLabel();
$date = $link->getCreated();
$age = Time::displayAge($date);
$views = $link->getViews();
$votes = $link->getVoteCount();
$rating = $link->getVoteRating(); ?>
<md-list-item class="md-3-line">
  <?= GDO_Avatar::renderAvatar($creator); ?>
  <div class="md-list-item-text" layout="column">
    <h3><?= GDT_LinkTitle::make()->gdo($link)->render(); ?></h3>
    <h4><?= $creator->displayName(); ?></h4>
    <p>
      <?= GDT_LevelPopup::make()->level($link->getLevel())->render(); ?>
      <?= GDT_VotePopup::make()->gdo($link)->render(); ?>
    </p>
  </div>
  <?= GDT_Link::make('link_view')->href($link->href_visit())->render(); ?>
</md-list-item>
