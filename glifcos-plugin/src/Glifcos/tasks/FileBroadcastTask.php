<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\PluginTask;

class FileBroadcastTask extends PluginTask {
    
    public $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if (empty($this->plugin->webserver)){
            return;
        }
        $this->plugin->filemgr_currentpath = base64_decode(file_get_contents(str_replace("server.php", "database/FILE_POINTER_PATH.txt", $this->plugin->webserver)));
        if (is_file($this->plugin->getServer()->getDataPath().$this->plugin->filemgr_currentpath)){
            $this->plugin->sendData(array(
                "request" => "INSTANT_FILE_SUBMIT",
                "filecontent" => base64_encode(file_get_contents($this->plugin->getServer()->getDataPath().$this->plugin->filemgr_currentpath))
                ));
            return;
        }
        else{
            if (is_dir($this->plugin->getServer()->getDataPath().$this->plugin->filemgr_currentpath)){
                $this->plugin->sendData(array(
                    "request" => "SimpleFileGlifcos",
                    "filedata" => base64_encode(json_encode(scandir($this->plugin->getServer()->getDataPath().$this->plugin->filemgr_currentpath)))
                ));
            }
            return;
        }
    }
    
}