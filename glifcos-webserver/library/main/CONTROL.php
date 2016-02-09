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

require $_COOKIE["cl"]."/library/main/guardian.php";
require $_COOKIE["cl"]."/library/ceoperands/talk.php";

if (isset($_GET["task"])){
    if ($_GET["task"] === "reload"){
        talk::reloadServer($_COOKIE["cl"]);
        sleep(4);
        talk::resetTalk($_COOKIE["cl"]);
        echo '
        <script> window.location = "hack_screen.php"; </script>
        ';
    }
    elseif ($_GET["task"] === "stop"){
        talk::stopServer($_COOKIE["cl"]);
        sleep(4);
        talk::resetTalk($_COOKIE["cl"]);
        echo '
        <script> window.location = "hack_screen.php"; </script>
        ';
    }
    else{
        die("Invalid connection!");
    }
}
else{
    die("Invalid connection!");
}