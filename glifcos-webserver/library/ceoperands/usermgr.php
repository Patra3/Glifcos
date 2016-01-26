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

class usermgr {
    public static function registerUser($username, $password, $base_dir){
        /**
         * Registers a user to the web console.
         * @param $username Username
         * @param $password Password
         * @param $base_dir The webserver base directory
         **/
        if (!is_dir($base_dir."/data/")){
            // this portion is not neccessary for user configuration.
            // but it is used for data purpose. do not delete.
            mkdir($base_dir."/data/");
        }
        if (!is_dir($base_dir."/users/")){
            mkdir($base_dir."/users/");
        }
        if (is_file($base_dir."/users/".$username.".json")){
            return false;
        }
        else{
            $handle = fopen($base_dir."/users/".$username.".json", "w+");
            fwrite($handle, json_encode(array("user" => $username, 
            "password" => password_hash($password, PASSWORD_DEFAULT))));
            fclose($handle);
            return true;
        }
        return false;
    }
    public static function loginUser($username, $password, $base_dir){
        /**
         * Logs a user into the webserver.
         * @param $username Username
         * @param $password Password
         * @param $base_dir The webserver base directory
         **/
         if (!is_file($base_dir."/users/".$username.".json")){
             return false;
         }
         else{
             $data = json_decode(file_get_contents($base_dir."/users/".$username.".json"), true);
             if (password_verify($password, $data["password"])){
                 return true;
             }
             else{
                 return false;
             }
         }
    }
}