<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;
$navbar instanceof GDO_Bar;
$navbar->addField(GDO_Link::make('links')->href(href('Links', 'Overview')));
