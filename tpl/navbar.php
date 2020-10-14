<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\Links\GDO_Link;
/** @var $navbar GDT_Bar **/
$count = GDO_Link::table()->getCounter();
$navbar->addField(GDT_Link::make()->label('link_links', [$count])->href(href('Links', 'Overview')));
