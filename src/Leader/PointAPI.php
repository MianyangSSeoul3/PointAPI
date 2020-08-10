<?php

namespace Leader;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;

class PointAPI extends PluginBase implements Listener {
  
  public $Pt;
  
  private static $instance;

  public static function getInstance() : self {
        return self::$instance;
    }

  public function onLoad(){
		self::$instance = $this;

	}
  
  public function onEnable() {
  $this->getServer()->getPluginManager()->registerEvents($this, $this);
	$this->getServer()->getLogger()->alert("[ LD_Point ] 포인트 플러그인");
	@mkdir($this->getDataFolder());
	$this->Point = new Config($this->getDataFolder()."PointAPI.yml",Config::YAML);
	$this->Pt = $this->Point->getAll();
  }
  
  public function onDisable() {
    $this->Point->setAll($this->Pt);
		$this->Point->save();
  }
  
  public function Join(PlayerJoinEvent $event) {
    $player = $event->getPlayer();
    $name = $player->getName();
    $player->sendMessage("§l§b[ Point ]§r§7 포인트플러그인을 사용중입니다.");
		if(!isset($this->Pt[$name])) { 
    $this->Pt[strtolower($name)]["포인트"] = "0";
    } 
  }
  
  public function getPoint(Player $player) {
		$name = $player->getName();
		return $this->Pt[strtolower($name)]["포인트"];
	}

  public function addPoint(Player $player , int $Point) {
    $name = $player->getName();
    $this->Pt[strtolower($name)]["포인트"] += "{$Point}";
  }
  
  public function setPoint(Player $player , int $Point) {
    $name = $player->getName();
    $this->Pt[strtolower($name)]["포인트"] = "{$Point}";
  }
  
  public function stPoint(Player $player , int $Point ) {
    $name = $player->getName();
    $this->Pt[strtolower($name)]["포인트"] -= "{$Point}";
  }
}