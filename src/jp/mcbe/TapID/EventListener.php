<?php

declare(strict_types=1);

namespace jp\mcbe\TapID;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

/**
 * Class EventListener
 * @package jp\mcbe\TapID
 */
class EventListener implements Listener {

  /** @var Main */
  private $main;

  public function __construct(Main $main) {
    $this->main = $main;
  }

  public function onTap(PlayerInteractEvent $ev) {
    if ($ev->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
      $player = $ev->getPlayer();
      if ($player->getInventory()->getItemInHand()->getId() === ItemIds::CLOCK) {
        if (strtotime("now") > $this->main->getLastTappedTime($player)) {
          $this->main->setLastTappedTime($player);
          $block = $ev->getBlock();
          $player->sendMessage(TextFormat::AQUA . "[{$this->main->getDescription()->getPrefix()}] ID: {$block->getId()}, ダメージ値: {$block->getDamage()}");
        }
      }
    }
  }

  public function onQuit(PlayerQuitEvent $ev) {
    $this->main->removeTimer($ev->getPlayer());
  }

}