<?php
use GDO\Date\Time;
use GDO\Links\GDO_Link;
use GDO\UI\GDT_Icon;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\Vote\GDT_VoteSelection;
use GDO\Links\GDT_LinkTitle;
use GDO\Avatar\GDO_Avatar;
use GDO\User\GDT_LevelPopup;
use GDO\UI\GDT_IconButton;

$link instanceof GDO_Link;
$user = GDO_User::current();
$creator = $link->getCreator();
?>
<?php
$username = $creator->displayNameLabel();
$date = $link->getCreated();
$age = Time::displayAge($date);
$views = $link->getViews();
$votes = $link->getVoteCount();
$rating = $link->getVoteRating();
?>
<md-list-item class="md-3-line">
  <?= GDO_Avatar::renderAvatar($creator); ?>
  <div class="md-list-item-text" layout="column">
    <h3><?= GDT_LinkTitle::make()->gdo($link)->render(); ?></h3>
    <h4><?= $creator->displayName(); ?></h4>
    <p>
      <?= GDT_LevelPopup::make()->level($link->getLevel())->renderCell(); ?>
    </p>
  </div>
<?php
if ($link->canView())
  GDT_Link::make('link_view')->href($link->href_visit())->renderCell();
?>
</md-list-item>
