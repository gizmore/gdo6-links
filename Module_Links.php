<?php
namespace GDO\Links;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Link;
use GDO\DB\GDT_Checkbox;
use GDO\User\GDT_Level;
use GDO\User\GDO_User;
use GDO\UI\GDT_Divider;
use GDO\DB\GDT_UInt;
use GDO\UI\GDT_Page;

/**
 * Links overview tagging and voting.
 * @author gizmore
 * @version 6.10.1
 * @since 3.1.0
 */
final class Module_Links extends GDO_Module
{
	public function getDependencies() { return ['Vote', 'Tag', 'Cronjob']; }
	public function getClasses() { return [GDO_Link::class, GDO_LinkTag::class, GDO_LinkVote::class]; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/links'); }
	
	##############
	### Config ###
	##############
	public function getConfig()
	{
		return [
		    GDT_Divider::make('cfg_links_meta'),
		    GDT_Checkbox::make('link_descriptions')->initial('1'),
			GDT_Checkbox::make('link_visible_levels')->initial('1'),
		    GDT_Divider::make('cfg_links_scoring'),
		    GDT_UInt::make('link_add_min')->initial('1'),
			GDT_UInt::make('link_add_max')->initial('100'),
			GDT_Level::make('link_add_min_level')->initial('0'),
			GDT_Level::make('link_add_per_level')->initial('0'),
		    GDT_Divider::make('cfg_links_votes'),
		    GDT_Checkbox::make('link_guest_votes')->initial('1'),
		    GDT_UInt::make('link_votes_outcome')->initial('3'),
		    GDT_Checkbox::make('link_left_bar')->initial('1'),
		];
	}
	public function cfgLevels() { return $this->getConfigValue('link_visible_levels'); }
	public function cfgDescriptions() { return $this->getConfigValue('link_descriptions'); }
	public function cfgAddMin() { return $this->getConfigValue('link_add_min'); }
	public function cfgAddMax() { return $this->getConfigValue('link_add_max'); }
	public function cfgAddMinLevel() { return $this->getConfigValue('link_add_min_level'); }
	public function cfgAddPerLevel() { return $this->getConfigValue('link_add_per_level'); }
	public function cfgVotesBeforeOutcome() { return $this->getConfigValue('link_votes_outcome'); }
	public function cfgGuestVotes() { return $this->getConfigValue('link_guest_votes'); }
	public function cfgAllowed(GDO_User $user)
	{
		$added = GDO_Link::table()->countWhere("link_created_by = {$user->getID()} AND link_deleted_at IS NULL");
		$bonus = $this->cfgAddPerLevel() > 0 ? round(max(0, ($user->getLevel() - $this->cfgAddMinLevel()) / $this->cfgAddPerLevel())) : 0;
		return max(0, $this->cfgAddMin() + $bonus - $added);
	}
	public function cfgLeftBar() { return $this->getConfigValue('link_left_bar'); }

	#################
	### Templates ###
	#################
	public function renderTabs()
	{
		return $this->responsePHP('tabs.php');
	}
	
	############
	### Init ###
	############
	public function onInitSidebar()
	{
	    if ($this->cfgLeftBar())
	    {
	        $count = GDO_Link::table()->getCounter();
	        $navbar = GDT_Page::$INSTANCE->leftNav;
	        $navbar->addField(GDT_Link::make()->label('link_links', [$count])->href(href('Links', 'Overview')));
	    }
	}
	
}
