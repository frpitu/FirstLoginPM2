<?php

declare (strict_types=1);

namespace FirstLogin;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

final class Plugin extends PluginBase implements Listener
{
	/** @var Config */
	public $joinnedListFile;

	public function onEnable()
	{
		@mkdir($this->getDataFolder());
		$this->joinnedListFile = new Config($this->getDataFolder() . 'joinned.txt', Config::ENUM);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		if (!$this->joinnedListFile->exists($player->getName())) {
			$player->sendMessage('§eAre you playing on this server for the first time? Welcome, ' . $player->getName());
			$this->joinnedListFile->set($player->getName());
			$this->joinnedListFile->save();
		}
	}
}
