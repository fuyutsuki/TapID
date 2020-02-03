<?php

declare(strict_types=1);

namespace jp\mcbe\TapID;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

/**
 * Class Main
 * @package jp\mcbe\TapID
 */
class Main extends PluginBase {

  /** @var int[] */
  private $timer = [];

  public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
  }

  public function getLastTappedTime(Player $player): int {
    return $this->timer[$player->getId()] ?? 0;
  }

  public function setLastTappedTime(Player $player) {
    $this->timer[$player->getId()] = strtotime("now");
  }

  public function removeTimer(Player $player) {
    unset($this->timer[$player->getId()]);
  }
}