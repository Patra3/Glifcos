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


namespace glifcos;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class glifcos extends PluginBase implements Listener {
    public function onEnable(){
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
        $res = $this->runServerCheck();
        $this->grudgesync();
        if (!$res){
            $this->getLogger()->warning("Glifcos could not verify the server. Please check your info in the config file.");
            $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin("Glifcos-p"));
        }
        $this->sellServerInfo();
    }
    private function runServerCheck(){
        $domain = $this->getConfig()->get("glifcos-domain");
        $data = fopen($domain."?type=ping", "r");
        $data2 = fread($data, 5);
        if ($data2 == "apple"){
            return true;
        }
        else{
            return false;
        }
    }
    private function grudgesync(){
        $link = $this->getConfig()->get("glifcos-domain");
        $data = array("ip" => json_decode(file_get_contents("http://api.ipify.org/?format=json")
        , true)["ip"],
        "port" => $this->getServer()->getPort());
        fopen($link."?type=grudgesync&grudge=".base64_encode(json_encode($data)), "r");
    }
    private function sellServerInfo(){
        // Don't take this angrily!! I'm just syncing
        // data with the webserver >~<
        $domain = $this->getConfig()->get("glifcos-domain");
        // this is to get the real external ip..
        
        $dat = array("ip" => json_decode(file_get_contents("http://api.ipify.org/?format=json")
        , true)["ip"], 
        "port" => $this->getServer()->getPort(), 
        "api" => $this->getServer()->getApiVersion(),
        "pm-v" => $this->getServer()->getPocketMineVersion(),
        "servern" => $this->getServer()->getServerName(),
        "motd" => $this->getServer()->getMotd(),
        );
        $compile = base64_encode(json_encode($dat));
        $data = fopen($domain."?type=updatedata&data=".$compile, "r");
        $this->getLogger()->info("Datasync sent to webserver.");
    }
    public function onJoin(PlayerJoinEvent $event){
        $domain = $this->getConfig()->get("glifcos-domain");
        
    }
}