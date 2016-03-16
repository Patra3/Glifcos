<?php
function curtPageURL() {
   // Solution found on webcheatsheet.com
   // http://webcheatsheet.com/php/get_current_page_url.php
   
   /*
   To be honest, I actually knew how to do this already,
   just that I didn't really want to scramble brainpower.
   Also, this is sorta a "hacky" thing, but... eh. 
   */
   $pageURL = 'http';
   if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
   $pageURL .= "://";
   if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   }
   return $pageURL;
}
if (isset($_GET["logout"])){
    setcookie("Authchain", "", time() + 2);
    echo '
    <script> window.location = "'.$_COOKIE["indexd"].'"; </script>
    ';
}
?>
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
        <!-- CUSTOM RALEWAY FONT -->
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
        <title>Glifcos</title>
    </head>
    <body <?php
    if (isset($_COOKIE["command_previous"])){
        if ($_COOKIE["command_previous"] === "yes"){
            sleep(2);
            echo 'onload="document.getElementById(\'id01\').style.display=\'block\'"';
        }
    }
    ?> style="font-family: Raleway, Serif;">
    <?php
    if (!empty($_COOKIE["Authchain"])){
        echo '
        <nav class="w3-topnav w3-green">
            <h2 style="font-family: Raleway, Serif;">
                Hi, 
                '.json_decode(base64_decode($_COOKIE["Authchain"]), true)["user"].'!
            </h2>
            <a href="'.$_COOKIE["indexd"].'?logout=" class="w3-right">
                Logout
            </a>
        </nav>
        ';
    }
    ?>
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
            if (!isset($_COOKIE["cl"])){
                if (is_file("core.json")){
                    echo '
                    <script> window.location = "index.php"; </script>
                    ';
                }
            }
            setcookie("cl", __DIR__, NULL, "/"); // sets main directory.
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