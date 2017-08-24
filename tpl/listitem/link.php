<?php
use GDO\Date\Time;
use GDO\Links\Link;
use GDO\UI\GDO_Icon;
use GDO\UI\GDO_Link;
use GDO\User\User;
use GDO\Vote\GDO_VoteSelection;

$link instanceof Link;
$user = User::current();
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
    <h3><?= GDO_Link::anchor(href('Links', 'Visit', '&id='.$link->getID()), html($link->getTitle())); ?></h3>
    <h4><?= t('li_link2', [$username, $age]); ?></h4>
    <span layout="row" flex layout-align="space-around center"><?= t('li_link3', [$link->gdoColumn('link_votes')->renderCell(), GDO_VoteSelection::make()->gdo($link)->renderCell(), $link->gdoColumn('link_rating')->renderCell()]) ?></span>
  </div>

  <?= GDO_Icon::iconS('arrow_right'); ?>
      
</md-list-item>
