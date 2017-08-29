<?php
namespace GDO\Links;

use GDO\Tag\GDO_TagTable;

final class GDO_LinkTag extends GDO_TagTable
{
    public function gdoTagObjectTable() { return GDO_Link::table(); }
}
