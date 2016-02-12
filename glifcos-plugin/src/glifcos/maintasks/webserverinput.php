<?php

namespace glifcos\maintasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class webserverinput extends PluginTask {
    public $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->start = false;
        parent::__construct($plugin);
    }
    public function onRun($ticks){
        if ($this->start){
            $data = file_get_contents(str_replace(
                "connection.php", "talk.json", $this->plugin->getConfig()->get("glifcos-domain")));
            $data = json_decode($data, true);
            if ($data["task"] != "none"){
                if ($data["task"] === "newsignin"){
                    $player = $data["user"];
                    $ip = $data["ip"];
                    $this->plugin->getLogger()->info("User ".$player." has logged into Glifcos.
                     IP: ".$ip);
                    $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                    unset($t);
                    unset($player);
                    unset($ip);
                }
                elseif ($data["task"] === "command"){
                    $this->plugin->renderCommand($data["command"]);
                    $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                    unset($t);
                }
                elseif ($data["task"] === "disableplugin"){
                    $this->plugin->getServer()->getPluginManager()->
                    disablePlugin($this->plugin->getServer()->getPluginManager()->getPlugin(
                        $data["plugin"]));
                    $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                    unset($t);
                }
                elseif ($data["task"] === "enableplugin"){
                    $this->plugin->getServer()->getPluginManager()->
                    enablePlugin($this->plugin->getServer()->getPluginManager()->getPlugin(
                        $data["plugin"]));
                    $t = fopen($this->plugin->getConfig()->get("glifcos-domain")."?type=recievedDATA", "r");
                    unset($t);
                }
                elseif ($data["task"] === "getdf"){
                    $base = $this->plugin->getServer()->getDataPath();
                    $additionalpath = $data["addpaths"];
                    $id = $data["id"];
                    $result = $this->plugin->scanDirectory($base."/".$additionalpath);
                    $arrat = array("type" => "filetransfer", "id" => $id, "data" => base64_encode(json_encode($result)));
                    $t = Utils::postURL($this->plugin->getConfig()->get("glifcos-domain"), $arrat);
                    unset($t);
                    unset($arrat);
                    unset($result);
                    unset($id);
                    unset($additionalpath);
                    unset($base);
                }
                elseif ($data["task"] === "updatedf"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (is_file($base.$data["filename"])){
                        unlink($base.$data["filename"]);
                    }
                    $handle = fopen($base.$data["filename"], "w+");
                    fwrite($handle, $data["newdata"]);
                    fclose($handle);
                    unset($handle);
                    unset($base);
                }
                elseif ($data["task"] === "deletef"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (is_file($base."/".$data["filename"])){
                        unlink($base."/".$data["filename"]);
                    }
                    elseif (is_dir($base."/".$data["filename"])){
                        $this->plugin->FolderRm($base."/".$data["filename"]);
                    }
                    unset($base);
                }
                elseif ($data["task"] === "renamef"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (is_file($base.$data["old"])){
                        rename($base.$data["old"], $base.$data["new"]);
                    }
                    elseif (is_dir($base.$data["old"])){
                        rename($base."/".$data["old"], $base."/".str_replace(".", "", $data["new"]));
                    }
                    unset($base);
                }
                elseif ($data["task"] === "movef"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (is_file($base."/".$data["oldm"])){
                        $datai = file_get_contents($base."/".$data["oldm"]);
                        unlink($base."/".$data["oldm"]);
                        $frt = pathinfo($base."/".$data["oldm"]);
                        $handle = fopen($base.$data["moveto"]."/".$frt["filename"].".".
                        $frt["extension"], "w+");
                        fwrite($handle, $datai);
                        fclose($handle);
                        unset($frt);
                        unset($handle);
                        unset($datai);
                    }
                    elseif (is_dir($base."/".$data["oldm"])){
                        if (!is_dir($base.$data["moveto"]."/".basename($data["oldm"]))){
                            mkdir($base.$data["moveto"]."/".basename($data["oldm"]));
                        }
                        $this->plugin->FolderCp($base."/".$data["oldm"], $base.$data["moveto"]."/".
                        basename($data["oldm"]));
                        $this->plugin->FolderRm($base."/".$data["oldm"]);
                    }
                    unset($base);
                }
                elseif ($data["task"] === "copyf"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (is_file($base."/".$data["oldm"])){
                        $frt = pathinfo($base."/".$data["oldm"]);
                        copy($base."/".$data["oldm"], $base.$data["moveto"]."/".$frt["filename"].".".
                        $frt["extension"]);
                        unset($frt);
                    }
                    elseif (is_dir($base."/".$data["oldm"])){
                        if (!is_dir($base.$data["moveto"]."/".basename($data["oldm"]))){
                            mkdir($base.$data["moveto"]."/".basename($data["oldm"]));
                        }
                        $this->plugin->FolderCp($base."/".$data["oldm"], $base.$data["moveto"]."/".
                        basename($data["oldm"]));
                    }
                    unset($base);
                }
                elseif ($data["task"] === "makefile"){
                    $base = $this->plugin->getServer()->getDataPath();
                    $t = fopen($base."/".$data["directory"]."/".$data["name"], "w+");
                    unset($base);
                    unset($t);
                }
                elseif ($data["task"] === "makefolder"){
                    $base = $this->plugin->getServer()->getDataPath();
                    if (!is_dir($base."/".$data["directory"]."/".$data["name"])){
                        mkdir($base."/".$data["directory"]."/".$data["name"]);
                    }
                    unset($base);
                }
                elseif ($data["task"] === "stop"){
                    $this->plugin->getServer()->stop();
                }
                elseif ($data["task"] === "reload"){
                    $this->plugin->getServer()->reload();
                    $this->plugin->getServer()->getPluginManager()->enablePlugin($this->plugin);
                }
            }
            unset($data);
            unset($t);
            gc_collect_cycles();
        }
        else{
            $this->start = true;
        }
    }
}