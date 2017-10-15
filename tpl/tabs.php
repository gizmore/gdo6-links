<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
$tabs = GDT_Bar::make()->horizontal();
$tabs->addField(GDT_Link::make('links')->href(href('Links', 'Overview')));
$tabs->addField(GDT_Link::make('add')->href(href('Links', 'Add')));
echo $tabs->render();
