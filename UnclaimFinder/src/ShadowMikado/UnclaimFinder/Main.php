<?php


namespace ShadowMikado\UnclaimFinder;


use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use ShadowMikado\UnclaimFinder\Events\UnclaimFinderListener;


class Main extends PluginBase
{
    private array $playerHasUnclaimFinder = [];


    protected function onEnable(): void
    {
        $this->getServer()->getLogger()->info("UnclaimFinder lancé avec succès");
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new UnclaimFinderListener($this), $this);
    }


    public function heldUnclaimFinder(Player $player): bool
    {
        return isset($this->playerHasUnclaimFinder[$player->getName()]);
    }

    public function checkHeldItem(Player $player, Item $item)
    {
        $config = $this->getConfig();
        $playername = $player->getName();
        $unclaimfinder = $config->get('UnclaimFinder');
        if ($item->getId() . ':' . $item->getMeta() === $unclaimfinder) {
            $this->playerHasUnclaimFinder[$playername] = true;
            $c = 0;
            $chunk = $player->getWorld()->getChunk($player->getPosition()->getX() >> 4, $player->getPosition()->getZ() >> 4);
            foreach ($chunk->getTiles() as $tile) $c++;
            $player->sendPopup("{$c}%%");
        } elseif ($this->heldUnclaimFinder($player)) {

            unset($this->playerHasUnclaimFinder[$playername]);
        }
    }


    public function onDisable(): void
    {
        $this->getServer()->getLogger()->info("UnclaimFinder arrété avec succès");
    }
}