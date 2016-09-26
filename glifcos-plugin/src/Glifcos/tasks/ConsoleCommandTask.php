<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\command\ConsoleCommandSender;

class ConsoleCommandTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        // manipulate webserver to get the command data file.
        if (empty($this->plugin->webserver)){
            return;
        }
        $webserver = str_replace("server.php", "database/commands.txt", $this->plugin->webserver);
        $content = file_get_contents($webserver);
        if (empty($content)){
            return;
        }
        $content = base64_decode($content);
        $content = json_decode($content);
        foreach($content as $command){
            $this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
        }
        $this->plugin->sendData(array(
            "request" => "GotConsoleCommand"
            ));
    }
    
}