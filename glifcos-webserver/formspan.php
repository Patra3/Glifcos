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
require "library/ceoperands/usermgr.php"; //user api.
if (isset($_POST["c-user"])){
    function first_setup($username, $password){
        // task is to generate the core.json file.
        $data = array("baseusr" => $username, 
        "basepwd" => password_hash($password, PASSWORD_DEFAULT), 
        "serverdata" => array(),
        "ranks" => array()
        );
        $handle = fopen("core.json", "w+");
        fwrite($handle, json_encode($data));
        fclose($handle);
    }
    $username = $_POST["c-user"];
    $password = $_POST["pwd"];
    $res = usermgr::registerUser($username, 
    $password, $_COOKIE["cl"]);
    if (!is_file("core.json")){
        first_setup($username, $password);
    }
    echo '<script>
    document.cookie="setup=3;";
    window.location="index.php";
    </script>';
}