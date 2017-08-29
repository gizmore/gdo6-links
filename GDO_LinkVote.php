<?php
namespace GDO\Links;

use GDO\Vote\GDO_VoteTable;

final class GDO_LinkVote extends GDO_VoteTable
{
    public function gdoVoteObjectTable() { return GDO_Link::table(); }
}
