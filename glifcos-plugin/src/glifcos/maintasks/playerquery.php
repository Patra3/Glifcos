<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class playerquery extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $listf = array();
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $name){
                $key = array_search($name, $this->plugin->getServer()->getOnlinePlayers());
                array_push($listf, $key);
            }
            $au = array("type" => "playerq", "total" => $this->plugin->getServer()->getMaxPlayers()
            , "current" => count($this->plugin->getServer()->getOnlinePlayers()), "lis" => 
            base64_encode(json_encode($listf)));
            $t = Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $au);
            unset($t);
            unset($listf);
            unset($au);
            unset($key);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}