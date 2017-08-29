<?php
use GDO\Date\Time;
use GDO\Links\GDO_Link;
use GDO\UI\GDT_Icon;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\Vote\GDT_VoteSelection;

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
  <div class="md-list-item-text" layout="column">
    <h3><?= GDT_Link::anchor(href('Links', 'Visit', '&id='.$link->getID()), html($link->getTitle())); ?></h3>
    <h4><?= t('li_link2', [$username, $age]); ?></h4>
    <span layout="row" flex layout-align="space-around center"><?= t('li_link3', [$link->gdoColumn('link_votes')->renderCell(), GDT_VoteSelection::make()->gdo($link)->renderCell(), $link->gdoColumn('link_rating')->renderCell()]) ?></span>
  </div>

  <?= GDT_Icon::iconS('arrow_right'); ?>
      
</md-list-item>
