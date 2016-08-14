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
        $this->plugin->sendData(array(
            "request" => "SimplePlayerGlifcos",
            "playerlist" => $this->plugin->getServer()->getOnlinePlayers()
            ));
    }
    
}