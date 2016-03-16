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

// POCKETMINE NAMESPACES
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;

// GLIFCOS NAMESPACES
use glifcos\maintasks\memorybroadcast;
use glifcos\maintasks\playerquery;
use glifcos\maintasks\consolebroadcast;
use glifcos\maintasks\webserverinput;
use glifcos\maintasks\cpubroadcast;
use glifcos\maintasks\pluginbroadcast;
use glifcos\maintasks\enabledplugin;

class glifcos extends PluginBase implements Listener {
    public $direct;
    public function onEnable(){
        if (!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
        }
        fopen($this->getConfig()->get("glifcos-domain")."?type=grudgesync&grudge=".base64_encode(json_encode(array(
            "ip" => json_decode(file_get_contents("http://api.ipify.org/?format=json"), true)["ip"],
            "port" => $this->getServer()->getPort()
            ))), "r");
        $res = $this->runServerCheck();
        if (!$res){
            $this->getLogger()->warning("Glifcos could not verify the server. Please check your info in the config file.");
            $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin("Glifcos-p"));
            return true;
        }
        $this->sellServerInfo();
        if (filesize($this->getServer()->getDataPath()."/server.log") > 10000000){
            $this->getLogger()->warning("Your server.log file is larger than 10MB.");
            $this->getLogger()->warning("PHP file read may cause your server to crash, depending
             on your server's RAM.");
        }
        /*
        REFERENCE:
        use glifcos\maintasks\memorybroadcast;
        use glifcos\maintasks\playerquery;
        use glifcos\maintasks\consolebroadcast;
        use glifcos\maintasks\webserverinput;
        use glifcos\maintasks\cpubroadcast;
        use glifcos\maintasks\pluginbroadcast;
        use glifcos\maintasks\enabledplugin;
        */
        //start all sync tasks.
        $tasktime = 20;
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new memorybroadcast($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new playerquery($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new consolebroadcast($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new webserverinput($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new cpubroadcast($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new pluginbroadcast($this), $tasktime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new enabledplugin($this), $tasktime);
        // ===
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    private function runServerCheck(){
        $domain = $this->getConfig()->get("glifcos-domain");
        $result = $this->url_exists($domain);
        if ($result === false){
            return false;
        }
        else{
            $data = fopen($domain."?type=ping", "r");
            $data2 = fread($data, 5);
            if ($data2 == "apple"){
                return true;
            }
            else{
                return false;
            }
        }
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
        "motd" => $this->getServer()->getMotd(),
        );
        $compile = base64_encode(json_encode($dat));
        $data = fopen($domain."?type=updatedata&data=".$compile, "r");
        $this->getLogger()->info(TextFormat::BLUE.TextFormat::BOLD.
        "Datasync sent to webserver.");
    }
    public function renderCommand($command){
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
    }
    public function onJoin(PlayerJoinEvent $event){
        $domain = $this->getConfig()->get("glifcos-domain");
        $t = fopen($domain."?type=playerloggedin&name=".$event->getPlayer()->getName()."&ip=".$event->getPlayer()->getAddress(), "r");
        unset($t);
        gc_collect_cycles();
    }
    public function onDisable(){
        /*
        if (!file_exists($this->getConfig()->get("glifcos-domain"))){
            return true;
        }
        */
        fopen($this->getConfig()->get("glifcos-domain")."?type=closedown", "r");
        $this->getLogger()->info(TextFormat::BLUE.TextFormat::BOLD.
        "Datasync sent to webserver.");
    }
    public function onDisconnect(PlayerQuitEvent $event){
        $domain = $this->getConfig()->get("glifcos-domain");
        $t = fopen($domain."?type=playerdisconnected&name=".$event->getPlayer()->getName(), "r");
        unset($t);
        gc_collect_cycles();
    }
    public function scanDirectory($base){
        $entire = array();
        foreach(scandir($base) as $stuff){
                if (is_file($base."/".$stuff)){
                    /*
                    Just for notability, if anyone wants to access the file array,
                    here is a small list of accessible keys:
                    - type
                    - lastmodded
                    - ext (extension)
                    - instantname
                    - data (content)
                    - size
                    */
                    $entire[$base."/".$stuff] = array("type" => "file", "lastmodded" =>
                    date("F d, Y H:i:s", filemtime($base."/".$stuff)), "ext" => pathinfo($base."/".$stuff, 
                    PATHINFO_EXTENSION), "instantname" => $stuff, "data" => 
                    mb_convert_encoding(file_get_contents($base."/".$stuff), "UTF-8", "UTF-8"),
                    "size" => filesize($base."/".$stuff));
                    if ($entire[$base."/".$stuff]["ext"] === "phar"){
                        unset($entire[$base."/".$stuff]["data"]);
                    }
                }
                elseif (is_dir($base."/".$stuff)){
                    $entire[$base."/".$stuff] = array("type" => "dir", "name" => $stuff);
                    $pointer = $base."/".$stuff;
                }
        }
        return $entire;
    }
    public function FolderRm($path){
        // RESOURCE FOUND AT STACKOVERFLOW.
        if (is_dir($path) === true){
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file){
                $this->FolderRm(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        }
        else if (is_file($path) === true){
            return unlink($path);
        }
        return false;
    }
    public function FolderCp($src, $dst) { 
        // RESOURCE FOUND AT STACKOVERFLOW.
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    $this->FolderCp($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                }
            } 
        } 
        closedir($dir); 
    } 
    public function url_exists($url){
        // RESOURCE FOUND AT PHP.NET
        // http://php.net/manual/en/function.file-exists.php#78656
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        } else {
            $url = array($url, "/");
        }

        $fh = fsockopen($url[0], 80);
        if ($fh) {
            fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return false; }
            else { return true;    }

        } else { return false;}
    }
    public function get_memory_load(){
        // RESOURCE FOUND AT PHP.NET
        // http://php.net/manual/en/function.sys-getloadavg.php#107243
        if (stristr(PHP_OS, 'win')) {
        
            $wmi = new COM("Winmgmts://");
            $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
            
            $cpu_num = 0;
            $load_total = 0;
            
            foreach($server as $cpu){
                $cpu_num++;
                $load_total += $cpu->loadpercentage;
            }
            
            $load = round($load_total/$cpu_num);
            
        } else {
        
            $sys_load = sys_getloadavg();
            $load = $sys_load[0];
        
        }
        
        return (int) $load;
    }
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        if ($sender instanceof Player){
            $sender->sendMessage(TextFormat::RED."This command is restricted to console or Glifcos only.");
            return true;
        }
        else{
            if (!isset($args[0])){
                $this->getLogger()->info("Please run 'glifcos help' for all available commands.");
            }
            elseif ($args[0] === "newuser"){
                if (!isset($args[1])){
                    $this->getLogger()->info("Command: glifcos newuser <username> <password>");
                }
                elseif (!isset($args[2])){
                    $this->getLogger()->info("Command: glifcos newuser <username> <password>");
                }
                else{
                    $user = urlencode($args[1]);
                    $pass = urlencode($args[2]);
                    $t = fopen($this->getConfig()->get("glifcos-domain")."?type=newuser&user=".$user."&pswd=".$pass, "r");
                    unset($t);
                    gc_collect_cycles();
                    $this->getLogger()->info(TextFormat::GREEN."User '".urldecode($user)."' created successfully.");
                }
            }
            return true;
        }
    }
}