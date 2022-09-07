<?php


namespace ShadowMikado\UnclaimFinder;


use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use ShadowMikado\UnclaimFinder\Events\UnclaimFinder;


class Main extends PluginBase
{
    public static Main $main;

    public Config $config;

    /**
     * @var Main
     */

    public function onLoad(): void
    {
        $this->getServer()->getLogger()->info("Starting UnclaimFinder Plugin...");

    }

    protected function onEnable(): void
    {
        $this->getServer()->getLogger()->info("UnclaimFinder Plugin Started");
        $this->saveDefaultConfig();
        $this->getScheduler()->scheduleRepeatingTask(new UnclaimFinder(), 20);
        self::$main = $this;
        $this->saveResource("config.yml");
    }



    public static function getInstance(): Main
    {
        return self::$main;
    }


    public function onDisable(): void
    {
        $this->getServer()->getLogger()->info("UnclaimFinder Plugin Stopped");
    }

    public function hasUnclaimFinder(Player $player): bool {
        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        if($player->getInventory()->getItemInHand()->getId() === $cfg->get("Unclaim Finder Id") and $player->getInventory()->getItemInHand()->getMeta() === $cfg->get("Unclaim Finder Meta")) {
            return true;
        }
        return false;
    }
}


