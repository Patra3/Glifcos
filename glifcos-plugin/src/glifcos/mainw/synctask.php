<?php

/*
THIS FILE IS PART OF THE GLIFCOS PROJECT BY @HOTFIREYDEATH.

THIS PROJECT IS LICENSED UNDER THE MIT LICENSE (MIT). A COPY OF 
THE LICENSE IS AVAILABLE WITH YOUR DOWNLOAD (LICENSE.txt).

      ___                                     ___           ___           ___           ___     
     /\__\                                   /\__\         /\__\         /\  \         /\__\    
    /:/ _/_                     ___         /:/ _/_       /:/  /        /::\  \       /:/ _/_   
   /:/ /\  \                   /\__\       /:/ /\__\     /:/  /        /:/\:\  \     /:/ /\  \  
  /:/ /::\  \   ___     ___   /:/__/      /:/ /:/  /    /:/  /  ___   /:/  \:\  \   /:/ /::\  \ 
 /:/__\/\:\__\ /\  \   /\__\ /::\  \     /:/_/:/  /    /:/__/  /\__\ /:/__/ \:\__\ /:/_/:/\:\__\
 \:\  \ /:/  / \:\  \ /:/  / \/\:\  \__  \:\/:/  /     \:\  \ /:/  / \:\  \ /:/  / \:\/:/ /:/  /
  \:\  /:/  /   \:\  /:/  /   ~~\:\/\__\  \::/__/       \:\  /:/  /   \:\  /:/  /   \::/ /:/  / 
   \:\/:/  /     \:\/:/  /       \::/  /   \:\  \        \:\/:/  /     \:\/:/  /     \/_/:/  /  
    \::/  /       \::/  /        /:/  /     \:\__\        \::/  /       \::/  /        /:/  /   
     \/__/         \/__/         \/__/       \/__/         \/__/         \/__/         \/__/    
*/

namespace glifcos\mainw;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class synctask extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            
            // === SEND MEMORY DATA TO WEBSERVER ===
            $cf = new Config($this->plugin->getServer()->getDataPath()."/server.properties", 
            Config::PROPERTIES);
            $cf = str_replace("M", "", $cf->get("memory-limit"));
            fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=memsync&cm=".round(
                memory_get_usage()/1000000)."&tm=".$cf, "r");
                
            // === SEND PLAYER QUERY TO WEBSERVER ===
            $listf = array();
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $name){
                $key = array_search($name, $this->plugin->getServer()->getOnlinePlayers());
                array_push($listf, $key);
            }
            $au = array("type" => "playerq", "total" => $this->plugin->getServer()->getMaxPlayers()
            , "current" => count($this->plugin->getServer()->getOnlinePlayers()), "lis" => 
            base64_encode(json_encode($listf)));
            Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $au);
            
            // === SEND CONSOLE LOG TO WEBSERVER ===
            $auf = array("type" => "console", "console" => base64_encode(file_get_contents($this->plugin->getServer()->
            getDataPath()."/server.log")));
            Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $auf);
            
            // === CHECK(S) FOR WEBSERVER INPUT ===
            $data = file_get_contents(str_replace(
                "connection.php", "talk.json", $this->plugin->getConfig()->get("glifcos-domain")));
            $data = json_decode($data, true);
            if ($data["task"] != "none"){
                if ($data["task"] === "newsignin"){
                    $player = $data["user"];
                    $ip = $data["ip"];
                    $this->plugin->getLogger()->info("User ".$player." has logged into Glifcos.
                     IP: ".$ip);
                    fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                }
                elseif ($data["task"] === "command"){
                    $this->plugin->renderCommand($data["command"]);
                    fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                }
                elseif ($data["task"] === "disableplugin"){
                    $this->plugin->getServer()->getPluginManager()->
                    disablePlugin($this->plugin->getServer()->getPluginManager()->getPlugin(
                        $data["plugin"]));
                    fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                }
                elseif ($data["task"] === "enableplugin"){
                    $this->plugin->getServer()->getPluginManager()->
                    enablePlugin($this->plugin->getServer()->getPluginManager()->getPlugin(
                        $data["plugin"]));
                    fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                }
            }
            
            // === SEND CPU DATA TO WEBSERVER ===
            fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=cpu&s=".
            sys_getloadavg()[0], "r");
            
            // === BROADCAST PLUGIN DATA TO WEBSERVER ===
            $plugint = array();
            foreach($this->plugin->getServer()->getPluginManager()->getPlugins() as $objects){
                $key = array_search($objects, $this->plugin->getServer()->
                getPluginManager()->getPlugins());
                array_push($plugint, $key);
            }
            $dty = array("type" => "pluginsy", "pluginss" => base64_encode(json_encode($plugint)));
            Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $dty);
        }
        else{
            $this->start = true;
        }
    }
}