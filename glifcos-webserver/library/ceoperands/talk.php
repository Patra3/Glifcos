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
         * Easy function to update talk. This function should not be used outside.
         * This is a private debugable function to update the talk online client.
         * Support for developers usage may be added in the future..
         * 
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
         $data = array("task" => "none");
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
         self::resetTalk($base_dir);
         return $content;
    }
    public static function updateFile($filename, $new_data, $base_dir){
        /**
         * Edits the given file on the client.
         * @param $filename The exact link to file, starting from base data path.
         * @param $new_data The new content.
         * @param $base_dir The webserver base directory
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        $data["task"] = "updatedf";
        $data["newdata"] = $_POST["sthap"];
        $data["filename"] = $filename;
        self::updateTalk($base_dir, $data);
    }
    public static function deleteFile($filename, $base_dir){
        /**
         * Deletes the given file on the client. Shared with folder as well.
         * @param $filename The exact link to file, starting from base data path.
         * @param $base_dir The webserver base directory
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        $data["task"] = "deletef";
        $data["filename"] = $filename;
        self::updateTalk($base_dir, $data);
    }
    public static function renameFile($origin, $newname, $base_dir){
        /**
         * Rename the given file on the client. Shared with folder as well.
         * @param $origin The exact link to the file, starting from base path.
         * @param $newname Rename file to...
         * @param $base_dir The webserver base directory
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        $data["task"] = "renamef";
        $data["old"] = $origin;
        $data["new"] = $newname;
        self::updateTalk($base_dir, $data);
    }
    public static function moveFile($file, $new_dir, $base_dir){
        /**
         * Moves the given file to the new directory. Shared with folder as well.
         * @param $file Target File
         * @param $new_dir The Target directory
         * @param $base_dir The webserver base directory
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        $data["task"] = "movef";
        $data["oldm"] = $file;
        $data["moveto"] = $new_dir;
        self::updateTalk($base_dir, $data);
    }
    public static function copyFile($file, $new_dir, $base_dir){
        /**
         * Copies the given file to the new directory. Shared with folder as well.
         * @param $file Target File
         * @param $new_dir The Target directory
         * @param $base_dir The webserver base directory
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        $data["task"] = "copyf";
        $data["oldm"] = $file;
        $data["moveto"] = $new_dir;
        self::updateTalk($base_dir, $data);
    }
    public static function makeNewFile($filename, $directory, $base_dir, $folder){
        /**
         * Makes a new file. Shared with folder creation as well.
         * @param $filename File
         * @param $directory Creation directory
         * @param $base_dir The webserver base directory
         * @param $folder Is it a folder? Default = false.
         **/
        $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
        if (!$folder){
            // FILE
            $data["task"] = "makefile";
            $data["name"] = $filename;
            $data["directory"] = $directory;
            self::updateTalk($base_dir, $data);
        }
        else{
            // FOLDER
            $data["task"] = "makefolder";
            $data["name"] = $filename;
            $data["directory"] = $directory;
            self::updateTalk($base_dir, $data);
        }
    }
    public static function stopServer($base_dir){
        /**
         * Stops the server.
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "stop";
         self::updateTalk($base_dir, $data);
    }
    public static function reloadServer($base_dir){
        /**
         * Reloads the server.
         * @param $base_dir The webserver base directory
         **/
         $data = json_decode(file_get_contents($base_dir."/talk.json"), true);
         $data["task"] = "reload";
         self::updateTalk($base_dir, $data);
    }
}