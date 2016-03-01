<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class cpubroadcast extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=cpu&s=".
            sys_getloadavg()[0], "r");
            unset($t);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}