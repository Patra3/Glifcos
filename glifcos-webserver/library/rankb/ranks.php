<?php

class ranks{
    public function addNewRank($name, $permissions, $base_dir){
        /**
         * Adds a new rank to Glifcos account mgrs.
         * @param $name Rank name.
         * @param $permissions[] Permissions settings.
         * @param $base_dir The webserver base directory
         **/
         if (!is_file($base_dir."/data/ranks.json")){
             $data = array();
         }
         else{
             $data = file_get_contents($base_dir."/data/ranks.json");
             $data = json_decode($data, true);
         }
         if (!isset($data[$name])){
             $data[$name] = $permissions;
         }
         else{
             return false;
         }
         if (is_file($base_dir."/data/ranks.json")){
             unlink($base_dir."/data/ranks.json");
         }
         $handle = fopen($base_dir."/data/ranks.json", "w+");
         fwrite($handle, json_encode($data));
         fclose($handle);
    }
    public function changeRankPerm($name, $permissions, $base_dir){
        /**
         * Changes rank permissions.
         * @param $name Rank name.
         * @param $permissions[] Permissions settings.
         * @param $base_dir The webserver base directory
         **/
        if (!is_file($base_dir."/data/ranks.json")){
            $data = array();
        }
        else{
            $data = file_get_contents($base_dir."/data/ranks.json");
            $data = json_decode($data, true);
        }
        if (!isset($data[$name])){
            self::addNewRank($name, $permission);
            return true;
        }
        else{
            $data[$name] = $permissions;
        }
        if (is_file($base_dir."/data/ranks.json")){
            unlink($base_dir."/data/ranks.json");
        }
        $handle = fopen($base_dir."/data/ranks.json", "w+");
        fwrite($handle, json_encode($data));
        fclose($handle);
    }
}