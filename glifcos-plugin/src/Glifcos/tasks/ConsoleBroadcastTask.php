<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;

class ConsoleBroadcastTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        $path = $this->plugin->getServer()->getDataPath();
        if (!is_file($path."/server.log")){
            $this->plugin->sendData(array(
                "request" => "SimpleConsoleGlifcos",
                "data" => false
                ));
            return;
        }
        else{
            clearstatcache();
            $lg = fopen($path."/server.log", "rb");
            fseek($lg, filesize($path."/server.log") - 2000);
            $text = fread($lg, 2000);
            fclose($lg);
            $this->plugin->sendData(array(
                "request" => "SimpleConsoleGlifcos",
                "data" => $text
                ));
            return;
        }
    }
    
}