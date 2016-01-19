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
            self::addUserType()
            return true;
        }
        return false;
    }
    public static function addUserType($type, $username, $base_dir){
        /**
         * Adds a specific account type tag. Required.
         * @param $type Account Type
         * @param $username Username
         * @param $base_dir The webserver base directory
         **/
        if (is_file($base_dir."/users/".$username.".json")){
            $data = file_get_contents($base_dir."/users/".$username.".json");
            $dbt = json_decode($data, true);
            $dbt["type"] = strtolower($type);
            unlink($base_dir."/users/".$username.".json");
            $handle = fopen($base_dir."/users/".$username.".json", "w+");
            fwrite($handle, json_encode($dbt));
            fclose($handle);
        }
        else{
            return false;
        }
    }
}