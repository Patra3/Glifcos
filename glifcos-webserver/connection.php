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
if (!is_dir("data/")){
    mkdir("data/");
}
if (isset($_GET["type"])){
    if ($_GET["type"] === "ping"){
        // send either "apple" or "grape"
        // apple = active, grape = error.
        echo "apple";
    }
    elseif ($_GET["type"] === "grudgesync"){
        $data = json_decode($_GET["grudge"], true);
        if (is_file("grudge.json")){
            unlink("grudge.json");
        }
        $handle = fopen("grudge.json", "w+");
        fwrite($handle, $data);
        fclose($handle);
    }
    elseif ($_GET["type"] === "updatedata"){
        $arrayt = $_GET["data"];
        $arrayt = base64_decode($arrayt);
        $arrayt = json_decode($arrayt, true);
        if (is_file("data/serverdata.json")){
            unlink("data/serverdata.json");
        }
        $handle = fopen("data/serverdata.json", "w+");
        fwrite($handle, json_encode($arrayt));
        fclose($handle);
        if (is_file("core.json")){
            $data = file_get_contents("core.json");
            $data = json_decode($data, true);
            $data["serverdata"] = $arrayt;
            $data = json_encode($data);
            unlink("core.json");
            $handle = fopen("core.json", "w+");
            fwrite($handle, $data);
            fclose($handle);
            unlink("data/serverdata.json");
        }
    }
}
else{
    die("Invalid connection.");
}