<?php

declare(strict_types=1);// phpの暗黙の型変換を抑制する

namespace jp\mcbe\TapID;

use pocketmine\Player;// 30行目で使用
use pocketmine\plugin\PluginBase;// 14行目で使用

/**
 * Class Main
 * @package jp\mcbe\TapID
 */
class Main extends PluginBase {

  /** @var int[] */
  private $timer = [];

  public function onEnable() {
    // EventListenerクラスをイベントのリスナーとして登録する
    // use文はMainクラスとEventListenerクラスが同じ名前空間内にあるので不要
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
  }

  /**
   * 最後にタップしたときのUnixタイムスタンプを連想配列から返す。なければ0。
   * @param Player $player
   * @return int Unixタイムスタンプ
   */
  public function getLastTappedTime(Player $player): int {
    return $this->timer[$player->getId()] ?? 0;
  }

  /**
   * 最後にタップしたときのUnixタイムスタンプを連想配列に入れて保存
   * @param Player $player
   */
  public function setLastTappedTime(Player $player) {
    $this->timer[$player->getId()] = strtotime("now");
  }

  /**
   * プレイヤーがログアウトしたときに連想配列からそのキーを持つデータを削除する
   * @param Player $player
   */
  public function removeTimer(Player $player) {
    unset($this->timer[$player->getId()]);
  }
}