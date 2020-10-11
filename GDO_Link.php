<?php
namespace GDO\Links;

use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_DeletedAt;
use GDO\Date\GDT_DateTime;
use GDO\Language\GDT_Language;
use GDO\Tag\WithTags;
use GDO\Core\GDT_Template;
use GDO\User\GDT_Level;
use GDO\User\GDO_User;
use GDO\Vote\GDT_VoteCount;
use GDO\Vote\GDT_VoteRating;
use GDO\Vote\WithVotes;
use GDO\DB\Cache;
use GDO\DB\GDT_UInt;

final class GDO_Link extends GDO
{
	############
	### Tags ###
	############
	use WithTags;
	public function gdoTagTable() { return GDO_LinkTag::table(); }

	#############
	### Votes ###
	#############
	use WithVotes;
	public function gdoVoteTable() { return GDO_LinkVote::table(); }
	public function gdoVoteAllowed(GDO_User $user) { return $user->getLevel() >= $this->getLevel(); }
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('link_id'),
		    GDT_LinkUrl::make('link_url'),
			GDT_LinkTitle::make('link_title'),
		    GDT_Language::make('link_lang')->emptyInitial(t('no_special_language')),
			GDT_LinkDescription::make('link_description'),
			GDT_Level::make('link_level')->notNull()->initial('0'),
			GDT_UInt::make('link_views')->notNull()->initial('0')->label('views'),
			GDT_VoteRating::make('link_rating')->orderableField(),
			GDT_VoteCount::make('link_votes')->orderableField(),
			GDT_DateTime::make('link_checked_at'),
			GDT_CreatedBy::make('link_created_by')->filterable(),
			GDT_CreatedAt::make('link_created_at')->orderableField(),
			GDT_DeletedAt::make('link_deleted_at'),
		);
	}

	##############
	### Getter ###
	##############
	/**
	 * @return GDO_User
	 */
	public function getCreator() { return $this->getValue('link_created_by'); }
	public function getCreatorID() { return $this->getVar('link_created_by'); }
	public function getCreated() { return $this->getVar('link_created_at'); }
	
	public function getID() { return $this->getVar('link_id'); }
	public function getURL() { return $this->getVar('link_url'); }
	public function getTitle() { return $this->getVar('link_title'); }
	public function getDescription() { return $this->getVar('link_description'); }
	public function getLevel() { return $this->getVar('link_level'); }
	public function getViews() { return $this->getVar('link_views'); }
	
	public function canView(GDO_User $user=null)
	{
	    $user = $user === null ? GDO_User::current() : $user;
	    return $user->getLevel() >= $this->getLevel();
	}
	
	public function displayDescription() { return $this->getDescription(); }
	
	############
	### HREF ###
	############
	public function href_visit() { return href('Links', 'Visit', '&id='.$this->getID()); }
	
	##############
	### Render ###
	##############
	public function renderList() { return GDT_Template::php('Links', 'listitem/link.php', ['link'=>$this]); }
	
	###########
	### All ###
	###########
	public static function getCounter()
	{
	    if (false === ($count = Cache::get('gdo_link_count')))
	    {
	        $count = self::table()->countWhere();
	        Cache::set('gdo_link_count', $count);
	    }
	    return $count;
	}
	
	public static function recacheCounter()
	{
	    Cache::remove('gdo_link_count');
	}
	
}
