<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;

class PlayerBroadcastTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        $player_names = array();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $players){
            array_push($player_names, $players->getName());
        }
        $this->plugin->sendData(array(
            "request" => "SimplePlayerGlifcos",
            "playerlist" => base64_encode(json_encode($player_names))
            ));
    }
    
}