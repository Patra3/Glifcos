<?php

namespace Glifcos;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\Player;

use Glifcos\tasks\AsyncDataSender;
use Glifcos\tasks\RamBroadcastTask;
use Glifcos\tasks\ConsoleBroadcastTask;
use Glifcos\tasks\ConsoleCommandTask;
use Glifcos\tasks\PlayerBroadcastTask;
use Glifcos\tasks\PluginBroadcastTask;
use Glifcos\tasks\FileBroadcastTask;

class Glifcos extends PluginBase {
    
    public $webserver;
    public $filemgr_currrentpath;
    public $settings;
    
    public function onEnable(){
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
        if (is_file($this->getDataFolder()."/data.txt")){
            $this->webserver = base64_decode(file_get_contents($this->getDataFolder()."/data.txt"));
        }
        $this->filemgr_currentpath = "/";
        $this->pingGlifcos();
        $this->sendData(array("request" => "SimpleOnlineGlifcos"));
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RamBroadcastTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new ConsoleBroadcastTask($this), 50);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new ConsoleCommandTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PlayerBroadcastTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PluginBroadcastTask($this), 100);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new FileBroadcastTask($this), 100);
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
            if ($sender instanceof Player){
                return true;
            }
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
            elseif ($args[0] === "disableplugin"){
                $plugin = $args[1];
                $plugin = $this->getServer()->getPluginManager()->getPlugin($plugin);
                if (empty($plugin)){
                    $this->getLogger()->warning("Plugin '".$args[1]."' does not exist, or is not enabled.");
                }
                else{
                    $this->getServer()->getPluginManager()->disablePlugin($plugin);
                    $this->getLogger()->info(TextFormat::GREEN."Plugin '".$args[1]."' disabled.");
                }
                return true;
            }
            elseif ($args[0] === "enableplugin"){
                $plugin = $args[1];
                $plugin = $this->getServer()->getPluginManager()->getPlugin($plugin);
                if (empty($plugin)){
                    $this->getLogger()->warning("Plugin '".$args[1]."' does not exist.");
                }
                else{
                    $this->getServer()->getPluginManager()->enablePlugin($plugin);
                    $this->getLogger()->info(TextFormat::GREEN."Plugin '".$args[1]."' enabled.");
                }
                return true;
            }
            elseif ($args[0] === "savecachedfile"){
                $file = $this->getServer()->getDataPath().$this->filemgr_currentpath;
                if (is_dir($file)){
                    return true;
                }
                unlink($file);
                $f = fopen($file, "w+");
                fwrite($f, base64_decode($args[1]));
                fclose($f);
                return true;
            }
            elseif ($args[0] === "deletecachedfile"){
                if (is_file($this->getServer()->getDataPath().$this->filemgr_currentpath)){
                    unlink($this->getServer()->getDataPath().$this->filemgr_currentpath);
                }
                return true;
            }
            elseif ($args[0] === "renamecachedfile"){
                $path = pathinfo($this->getServer()->getDataPath().$this->filemgr_currentpath);
                if (is_file($this->getServer()->getDataPath().$this->filemgr_currentpath)){
                    rename($this->getServer()->getDataPath().$this->filemgr_currentpath, str_replace($path["basename"], base64_decode($args[1]), $this->getServer()->getDataPath().$this->filemgr_currentpath));
                }
                return true;
            }
            elseif ($args[0] === "addnewfile"){
                $file = base64_decode($args[1]);
                fopen($this->getServer()->getDataPath().$file, "w+");
                return true;
            }
            elseif ($args[0] === "addnewdir"){
                $dir = base64_decode($args[1]);
                mkdir($this->getServer()->getDataPath().$dir);
                return true;
            }
        }
    }
    
    public function onDisable(){
        
        // AsyncTask doesn't work during disables, so the sendData() method is useless.
        // Send using origin method.
        Utils::postURL($this->webserver, array(
            "request" => "SimpleOfflineGlifcos"
            ));
            
    }
}