<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class memorybroadcast extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $cf = new Config($this->plugin->getServer()->getDataPath()."/server.properties", 
            Config::PROPERTIES);
            $cf = str_replace("M", "", $cf->get("memory-limit"));
            $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=memsync&cm=".round(
                memory_get_usage()/1000000)."&tm=".$cf, "r");
            unset($t);
            unset($cf);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}