<?php

namespace ShadowMikado\UnclaimFinder\Events;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;
use ShadowMikado\UnclaimFinder\Main;

class UnclaimFinder extends Task
{
    private int $time;

    public function __construct(int $time = 1)
    {
        $this->time = $time;
    }

    public function onRun(): void
    {
        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $world = Server::getInstance()->getWorldManager()->getWorldByName($cfg->get("World Name"));
        foreach ($world->getPlayers() as $player) {

            if(Main::getInstance()->hasUnclaimFinder($player)) {
                if ($this->time === 0) {
                    $c = 0;
                    $chunk = $player->getWorld()->getChunk($player->getPosition()->getX() >> 4, $player->getPosition()->getZ() >> 4);
                    foreach ($chunk->getTiles() as $tile) $c++;
                    $player->sendPopup("{$c}%%");
                    $this->time = 1;
                }

                $this->time--;

            }
        }
    }

}