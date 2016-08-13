<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;

class RamBroadcastTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        $cf = new Config($this->plugin->getServer()->getDataPath()."/server.properties", Config::PROPERTIES);
        $cf = str_replace("M", "", $cf->get("memory-limit"));
        $this->plugin->sendData(array(
            "request" => "SimpleRAMGlifcos",
            "current_ram_usage" => round(memory_get_usage()/1000000),
            "max_ram_limit" => $cf
            ));
    }
}