<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class consolebroadcast extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $auf = array("type" => "console", "console" => base64_encode(file_get_contents($this->plugin->getServer()->
            getDataPath()."/server.log")));
            $t = Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $auf);
            unset($t);
            unset($auf);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}