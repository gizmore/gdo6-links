<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;
use GDO\Links\Link;
$navbar instanceof GDO_Bar;
$count = Link::table()->countWhere();
$navbar->addField(GDO_Link::make()->label('link_links', [$count])->href(href('Links', 'Overview')));
