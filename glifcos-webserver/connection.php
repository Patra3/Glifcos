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
function updateCore($array){
    if (is_file("core.json")){
        unlink("core.json");
    }
    $handle = fopen("core.json", "w+");
    fwrite($handle, json_encode($array));
    fclose($handle);
}
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
        $data = base64_decode($_GET["grudge"]);
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
            updateCore($data);
            unlink("data/serverdata.json");
        }
    }
    elseif ($_GET["type"] === "memsync"){
        $current = $_GET["cm"]; // current memory usage.
        $total = $_GET["tm"]; // total memory limit.
    
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["currentmemory"] = $current;
        $coredata["serverdata"]["totalmemory"] = $total;
        updateCore($coredata);
    }
    elseif ($_GET["type"] === "closedown"){
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["status"] = "closed";
        updateCore($coredata);
    }
    elseif ($_GET["type"] === "startup"){
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["status"] = "started";
        updateCore($coredata);
    }
    elseif ($_GET["type"] === "recievedDATA"){
        require "library/ceoperands/talk.php";
        talk::resetTalk(getcwd());
    }
    elseif ($_GET["type"] === "cpu"){
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["currentcpu"] = $_GET["s"];
        updateCore($coredata);
    }
}
elseif (isset($_POST["type"])){
    if ($_POST["type"] === "playerq"){
        $total = $_POST["total"];
        $current = $_POST["current"];
        $lis = json_decode(base64_decode($_POST["lis"]), true);
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["playerquery"] = array("total" => $total, "currentamount" => $current,
        "list" => $lis);
        updateCore($coredata);
    }
    elseif ($_POST["type"] === "console"){
        $long = base64_decode($_POST["console"]);
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["console"] = $long;
        updateCore($coredata);
    }
    elseif ($_POST["type"] === "pluginsy"){
        $list = json_decode(base64_decode($_POST["pluginss"]), true);
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["plugins"] = $list;
        updateCore($coredata);
    }
    elseif ($_POST["type"] === "pluginenabled."){
        $plugindata = json_decode(base64_decode($_POST["pluginss"]), true);
        $coredata = json_decode(file_get_contents("core.json"), true);
        $coredata["serverdata"]["p-enabledor"] = $plugindata;
        updateCore($coredata);
    }
    elseif ($_POST["type"] === "filetransfer"){
        $file = fopen("data/".$_POST["id"].".json", "w+");
        fwrite($file, base64_decode($_POST["data"]));
        fclose($file);
    }
}
else{
    die("Invalid connection.");
}