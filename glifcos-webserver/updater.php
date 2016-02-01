<?php

class Updater {
    public static function generateDataFolder(){
        if (!is_dir("update/")){
            mkdir("update/");
        }
    }
    public static function Update(){
        $process = json_decode(file_get_contents("update/update.json"), true);
        foreach($process as $link){
            $data = file_get_contents($link);
            $old_file_pack = array_search($link, $process);
            if (is_file($old_file_pack)){
                unlink($old_file_pack);
            }
            $handle = fopen($old_file_pack, "w+");
            fwrite($handle, $data);
            fclose($handle);
        }
    }
}