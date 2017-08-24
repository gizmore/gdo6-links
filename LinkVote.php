<?php
namespace GDO\Links;

use GDO\Vote\VoteTable;

final class LinkVote extends VoteTable
{
	public function gdoVoteObjectTable() { return Link::table(); }
}
