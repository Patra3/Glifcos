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
            if (empty(memory_get_usage())){
                $this->getLogger()->error("Memory usage detection is blocked.");
                $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=memsync&cm=1"
                ."&tm=".$cf, "r");
            }
            $cf = new Config($this->plugin->getServer()->getDataPath()."/server.properties", 
            Config::PROPERTIES);
            $cf = str_replace("M", "", $cf->get("memory-limit"));
            $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=memsync&cm=".round(
                $this->plugin->get_memory_load())."&tm=".$cf, "r");
            unset($t);
            unset($cf);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}