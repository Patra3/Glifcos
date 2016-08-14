<?php

namespace Glifcos;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;

use Glifcos\tasks\AsyncDataSender;
use Glifcos\tasks\RamBroadcastTask;
use Glifcos\tasks\ConsoleBroadcastTask;
use Glifcos\tasks\ConsoleCommandTask;
use Glifcos\tasks\PlayerBroadcastTask;

class Glifcos extends PluginBase {
    
    public $webserver;
    public $settings;
    
    public function onEnable(){
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
        if (is_file($this->getDataFolder()."/data.txt")){
            $this->webserver = base64_decode(file_get_contents($this->getDataFolder()."/data.txt"));
        }
        $this->pingGlifcos();
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RamBroadcastTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new ConsoleBroadcastTask($this), 50);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new ConsoleCommandTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PlayerBroadcastTask($this), 100);
    }
    
    /**
     * Ping Glifcos webserver, sending data and a flare.
     * @return void
     * */
    public function pingGlifcos(){
        $this->sendData(array(
            "request" => "SimplePingGlifcos",
            "ip" => json_decode(file_get_contents("http://api.ipify.org/?format=json"), true)["ip"],
            "port" => $this->getServer()->getPort(),
            "version" => $this->getServer()->getPocketMineVersion(),
            "codename" => $this->getServer()->getCodename(),
            "maxplayers" => $this->getServer()->getMaxPlayers(),
            "name" => $this->getServer()->getServerName(),
            "motd" => $this->getServer()->getMotd()
        ));
    }
    
    /**
     * Sends a data batch to Glifcos.
     * @param $data Array[]
     * @return void
     * */
    public function sendData($data){
        return $this->getServer()->getScheduler()->scheduleAsyncTask(new AsyncDataSender(json_encode($data), $this->webserver));
    }
    
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        if (strtolower($command->getName()) === "glifcos"){
            if (!isset($args[0])){
                $sender->sendMessage("");
                return true;
            }
            elseif ($args[0] === "setup"){
                if (!isset($args[1])){
                    $sender->sendMessage(TextFormat::YELLOW."Please setup the webserver and perform the requested command.");
                    return true;
                }
                else{
                    if (is_file($this->getDataFolder()."/data.txt")){
                        unlink($this->getDataFolder()."/data.txt");
                    }
                    $data = fopen($this->getDataFolder()."/data.txt","w+");
                    fwrite($data, $args[1]);
                    fclose($data);
                    $sender->sendMessage(TextFormat::GREEN."Configuration saved. Please restart your server for changes to take effect.");
                    return true;
                }
            }
        }
    }
}