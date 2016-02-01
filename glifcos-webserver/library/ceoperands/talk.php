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

class talk {
    private static function updateTalk($base_dir, $array){
        /**
         * Easy function to update talk. This should not be used outside the talk.php file.
         * @param $base_dir The webserver base directory
         **/
        if (is_file($base_dir."/talk.json")){
            unlink($base_dir."/talk.json");
        }
        $handle = fopen($base_dir."/talk.json", "w+");
        fwrite($handle, json_encode($array));
        fclose($handle);
    }
    public static function createTalk($base_dir){
        /**
         * Creates the server communication file.
         * @param $base_dir The webserver base directory
         **/
        if (!is_file($base_dir."/talk.json")){
            $handle = fopen($base_dir."/talk.json", "w+");
            fwrite($handle, json_encode(array(
                "task" => "none"
                )));
            fclose($handle);
        }
        else{
            return false;
        }
    }
    public static function broadcastNewSignIn($username, $clientip, $base_dir){
        /**
         * Alerts the console of a new login..
         * @param $username Username
         * @param $clientip IP address ($_SERVER['REMOTE_ADDR'])
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "newsignin";
         $data["user"] = $username;
         $data["ip"] = $clientip;
         self::updateTalk($base_dir, $data);
    }
    public static function resetTalk($base_dir){
        /**
         * Resets the talk.json file reciever.
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "none";
         foreach($data as $obt){
             $key = array_search($obt, $data);
             if ($key != "task"){
                 unset($data[$key]);
             }
         }
         self::updateTalk($base_dir, $data);
    }
    public static function relayCommand($command, $base_dir){
        /**
         * Relay a command to PocketMine (console).
         * @param $command Command
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "command";
         $data["command"] = $command;
         self::updateTalk($base_dir, $data);
    }
    public static function enablePlugin($plugin, $base_dir){
        /**
         * Enable a plugin
         * @param $plugin String
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "enableplugin";
         $data["plugin"] = $plugin;
         self::updateTalk($base_dir, $data);
    }
    public static function disablePlugin($plugin, $base_dir){
        /**
         * Disable a plugin
         * @param $plugin String
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "disableplugin";
         $data["plugin"] = $plugin;
         self::updateTalk($base_dir, $data);
    }
    public static function requestFileData($id, $flags, $base_dir){
        /**
         * Fetch local server files.
         * @param $id Request ID
         * @param $flags Additional navs
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "getdf";
         $data["addpaths"] = $flags;
         $data["id"] = $id;
         self::updateTalk($base_dir, $data);
         do {
             sleep(1);
         }
         while(!is_file($base_dir."/data/".$id.".json"));
         $content = json_decode(file_get_contents($base_dir."/data/".$id.".json"), true);
         unlink($base_dir."/data/".$id.".json");
         return $content;
    }
}