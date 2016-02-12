<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class pluginbroadcast extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $plugint = array();
            foreach($this->plugin->getServer()->getPluginManager()->getPlugins() as $objects){
                $key = array_search($objects, $this->plugin->getServer()->
                getPluginManager()->getPlugins());
                array_push($plugint, $key);
            }
            $dty = array("type" => "pluginsy", "pluginss" => base64_encode(json_encode($plugint)));
            $t = Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $dty);
            unset($t);
            unset($dty);
            unset($plugint);
            unset($key);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}