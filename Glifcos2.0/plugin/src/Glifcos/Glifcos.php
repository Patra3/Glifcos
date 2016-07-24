<?php

namespace Glifcos;

use pocketmine\plugin\PluginBase;

class Glifcos extends PluginBase {
    public function onEnable(){
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
    }
}