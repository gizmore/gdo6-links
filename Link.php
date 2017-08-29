<?php
namespace GDO\Links;

use GDO\DB\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_DeletedAt;
use GDO\Date\GDT_DateTime;
use GDO\Language\GDT_Language;
use GDO\Tag\WithTags;
use GDO\Template\GDT_Template;
use GDO\Type\GDT_Int;
use GDO\Type\GDT_Message;
use GDO\User\GDT_Level;
use GDO\User\User;
use GDO\Vote\GDT_VoteCount;
use GDO\Vote\GDT_VoteRating;
use GDO\Vote\WithVotes;

final class Link extends GDO
{
	############
	### Tags ###
	############
	use WithTags;
	public function gdoTagTable() { return LinkTag::table(); }

	#############
	### Votes ###
	#############
	use WithVotes;
	public function gdoVoteTable() { return LinkVote::table(); }
	public function gdoVoteMin() { return 1; }
	public function gdoVoteMax() { return 5; }
	public function gdoVotesBeforeOutcome() { return Module_Links::instance()->cfgVotesBeforeOutcome(); }
	public function gdoVoteAllowed(User $user) { return $user->getLevel() >= $this->getLevel(); }
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('link_id'),
			GDT_LinkUrl::make('link_url'),
			GDT_LinkTitle::make('link_title'),
			GDT_Language::make('link_lang'),
			GDT_Message::make('link_description')->notNull()->min(3)->max(512)->label('description'),
			GDT_Level::make('link_level')->notNull()->unsigned()->initial('0'),
			GDT_Int::make('link_views')->notNull()->unsigned()->initial('0')->label('views'),
			GDT_VoteRating::make('link_rating'),
			GDT_VoteCount::make('link_votes'),
			GDT_DateTime::make('link_checked_at'),
			GDT_CreatedBy::make('link_created_by'),
			GDT_CreatedAt::make('link_created_at'),
			GDT_DeletedAt::make('link_deleted_at'),
		);
	}

	##############
	### Getter ###
	##############
	/**
	 * @return User
	 */
	public function getCreator() { return $this->getValue('link_created_by'); }
	public function getCreatorID() { return $this->getVar('link_created_by'); }
	public function getCreated() { return $this->getVar('link_created_at'); }
	
	public function getID() { return $this->getVar('link_id'); }
	public function getURL() { return $this->getVar('link_url'); }
	public function getTitle() { return $this->getVar('link_title'); }
	public function getLevel() { return $this->getVar('link_level'); }
	public function getViews() { return $this->getVar('link_views'); }
	
	############
	### HREF ###
	############
	public function href_visit() { return href('Links', 'Visit', '&id='.$this->getID()); }
	
	##############
	### Render ###
	##############
	public function renderList() { return GDT_Template::php('Links', 'listitem/link.php', ['link'=>$this]); }
}
