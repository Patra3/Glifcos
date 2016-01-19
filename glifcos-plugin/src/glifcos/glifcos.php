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

class glifcos extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->sellServerInfo();
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
        $res = $this->runServerCheck();
        if (!$res){
            $this->getLogger()->warning("Glifcos could not verify the server. Please check your info in the config file.");
            $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin("Glifcos-p"));
        }
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
    private function sellServerInfo(){
        // Don't take this angrily!! I'm just syncing
        // data with the webserver >~<
        $domain = $this->getConfig()->get("glifcos-domain");
        $dat = array("ip" => $this->getServer()->getIp(), 
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
}