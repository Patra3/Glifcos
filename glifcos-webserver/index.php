<html>
    <head>
        <!--
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
        -->
        <!-- W3 CSS -->
        <link rel="stylesheet" href="w3.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- COMPAT -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Glifcos</title>
    </head>
    <body <?php 
    require "updater.php";
    Updater::generateDataFolder();
    if (isset($_COOKIE["command_previous"])){
        if ($_COOKIE["command_previous"] === "yes"){
            echo 'onload="'.file_get_contents($_COOKIE["cl"].
            "/library/main/modalhacks/main-console-show.txt")
            .'"';
        }
    }
    ?>>
        <div class="w3-container">
            <?php
            require "library/ceoperands/talk.php";
            function normal(){
                require "library/main/dashboard.php";
                return true;
            }
            if (isset($_COOKIE["cl"])){
                setcookie("cl", "", time());
            }
            if (isset($_COOKIE["Authchain"])){
                require "library/main/mainstart.php";
                goto skip;
            }
            setcookie("cl", getcwd(), NULL, "/"); // sets main directory.
            if (isset($_COOKIE["setup"])){
                if ($_COOKIE["setup"] === "2"){
                    require 'library/setupc/setup2.php';
                    goto skip;
                }
                elseif ($_COOKIE["setup"] === "3"){
                    setcookie("setup", "", time());
                    normal();
                }
            }
            if (!is_file("core.json")){
                require 'library/setupc/setup1.php';
            }
            else{
               normal(); 
            }
            skip:
                talk::createTalk($_COOKIE["cl"]);
            ?>
        </div>
    </body>
</html>