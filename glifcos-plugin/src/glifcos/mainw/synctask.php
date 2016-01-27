<?php

namespace glifcos\mainw;

use pocketmine\scheduler\PluginTask;

class synctask extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $this->plugin->getLogger()->info("hi");
        }
        else{
            $this->start = true;
        }
    }
}