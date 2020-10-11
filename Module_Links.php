<?php
namespace GDO\Links;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Bar;
use GDO\DB\GDT_Checkbox;
use GDO\User\GDT_Level;
use GDO\User\GDO_User;
use GDO\UI\GDT_Divider;
use GDO\DB\GDT_UInt;

final class Module_Links extends GDO_Module
{
	public function getDependencies() { return ['Vote', 'Tag', 'Cronjob']; }
	public function getClasses() { return ['GDO\Links\GDO_Link', 'GDO\Links\GDO_LinkTag', 'GDO\Links\GDO_LinkVote']; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/links'); }
	
	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
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
		);
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

	#################
	### Templates ###
	#################
	public function renderTabs()
	{
		return $this->responsePHP('tabs.php');
	}
	
	public function hookLeftBar(GDT_Bar $navbar)
	{
		$this->templatePHP('navbar.php', ['navbar'=>$navbar]);
	}
}
