<?php
use GDO\Template\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\Links\GDO_Link;
$navbar instanceof GDT_Bar;
$count = GDO_Link::table()->countWhere();
$navbar->addField(GDT_Link::make()->label('link_links', [$count])->href(href('Links', 'Overview')));
