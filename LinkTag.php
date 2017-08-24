<?php
namespace GDO\Links;

use GDO\Tag\TagTable;

final class LinkTag extends TagTable
{
	public function gdoTagObjectTable() { return Link::table(); }
}
