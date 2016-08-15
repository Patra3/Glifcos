<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;

class PluginBroadcastTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        $plugin_ar = array();
        foreach($this->plugin->getServer()->getPluginManager()->getPlugins() as $plugins){
            $plugin_ar[$plugins->getName()] = array(
                "enabled" => $this->plugin->getServer()->getPluginManager()->isPluginEnabled($plugins)
            );
        }
        $this->plugin->sendData(array(
            "request" => "SimplePluginGlifcos",
            "plugindata" => base64_encode(json_encode($plugin_ar))
            ));
    }
    
}