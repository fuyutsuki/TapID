<?php

declare(strict_types=1);

namespace jp\mcbe\TapID;

use pocketmine\event\Listener;// 17行目で使用
use pocketmine\event\player\PlayerInteractEvent;// 26, 28行目で使用
use pocketmine\event\player\PlayerQuitEvent;// 42行目で使用
use pocketmine\item\ItemIds;// 31行目で使用
use pocketmine\utils\TextFormat;// 36行目で使用

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
    // もしPlayerInteractEventの行動内容が"ブロックを右クリック"なら
    if ($ev->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
      $player = $ev->getPlayer();
      // もしプレイヤーのインベントリから手に持ってるアイテムのIDを取得して、時計と同じなら
      if ($player->getInventory()->getItemInHand()->getId() === ItemIds::CLOCK) {
        // もし現在のUnixタイムスタンプが最後にタップしたときのUnixタイムスタンプより大きければ(1秒以上経っていれば)
        if (strtotime("now") > $this->main->getLastTappedTime($player)) {
          $this->main->setLastTappedTime($player);
          $block = $ev->getBlock();
          $player->sendMessage(TextFormat::AQUA . "[{$this->main->getDescription()->getPrefix()}] ID: {$block->getId()}, ダメージ値: {$block->getDamage()}");
        }
      }
    }
  }

  public function onQuit(PlayerQuitEvent $ev) {
    // $this->mainに入っているMainクラスのremoveTimer関数にPlayerを渡す
    $this->main->removeTimer($ev->getPlayer());
  }

}