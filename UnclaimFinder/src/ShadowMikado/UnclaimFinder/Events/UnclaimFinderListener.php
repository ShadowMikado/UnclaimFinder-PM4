<?php

namespace ShadowMikado\UnclaimFinder\Events;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use ShadowMikado\UnclaimFinder\Main;

class UnclaimFinderListener implements Listener
{
    private Main $main;


    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function getItemHeld(PlayerItemHeldEvent $event)
    {
        $this->main->checkHeldItem($event->getPlayer(), $event->getItem());
    }


    public function QuitEvent(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkHeldItem($player, ItemFactory::air());
    }

    public function JoinEvent(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkHeldItem($player, $player->getInventory()->getItemInHand());
    }

}