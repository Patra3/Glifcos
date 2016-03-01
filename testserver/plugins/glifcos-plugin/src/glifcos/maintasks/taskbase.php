<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class {task} extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            
        }
        else{
            $this->start = true;
        }
    }
}