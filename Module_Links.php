<?php
namespace GDO\Links;

use GDO\Core\Module;
use GDO\Template\GDO_Bar;
use GDO\Type\GDO_Checkbox;
use GDO\Type\GDO_Int;
use GDO\User\GDO_Level;
use GDO\User\User;

final class Module_Links extends Module
{
	public function getClasses() { return ['GDO\Links\Link', 'GDO\Links\LinkTag', 'GDO\Links\LinkVote']; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/links'); }
	
	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
			GDO_Checkbox::make('link_descriptions')->initial('1'),
			GDO_Checkbox::make('link_visible_levels')->initial('1'),
			GDO_Int::make('link_add_min')->unsigned()->initial('1')->label('link_add_min'),
			GDO_Int::make('link_add_max')->unsigned()->initial('100')->label('link_add_max'),
			GDO_Level::make('link_add_min_level')->initial('0')->label('link_add_min_level'),
			GDO_Level::make('link_add_per_level')->initial('0')->label('link_add_per_level'),
			GDO_Int::make('link_votes_outcome')->unsigned()->initial('1')->label('link_votes_outcome'),
		);
	}
	public function cfgLevels() { return $this->getConfigValue('link_visible_levels'); }
	public function cfgDescriptions() { return $this->getConfigValue('link_descriptions'); }
	
	public function cfgAddMin() { return $this->getConfigValue('link_add_min'); }
	public function cfgAddMax() { return $this->getConfigValue('link_add_max'); }
	public function cfgAddMinLevel() { return $this->getConfigValue('link_add_min_level'); }
	public function cfgAddPerLevel() { return $this->getConfigValue('link_add_per_level'); }
	public function cfgVotesBeforeOutcome() { return $this->getConfigValue('link_votes_outcome'); }
	public function cfgAllowed(User $user)
	{
		$added = Link::table()->countWhere("link_created_by = {$user->getID()} AND link_deleted_at IS NULL");
		$bonus = $this->cfgAddPerLevel() > 0 ? round(max(0, ($user->getLevel() - $this->cfgAddMinLevel()) / $this->cfgAddPerLevel())) : 0;
		return max(0, $this->cfgAddMin() + $bonus - $added);
	}

	#################
	### Templates ###
	#################
	public function renderTabs()
	{
		return $this->templatePHP('tabs.php');
	}
	
	public function hookLeftBar(GDO_Bar $navbar)
	{
		return $this->templatePHP('navbar.php', ['navbar'=>$navbar]);
	}
}
