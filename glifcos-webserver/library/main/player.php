<?php
class PlayerData {
    public static function getPlayerData($player_name, $base_dir){
        /**
         * Gets the player data in the original array format.
         * @param $player_name String
         * @param $base_dir base webserver directory
         * */
        chdir($base_dir."/players");
        if (!is_file($player_name.".json")){
            return false;
        }
        return json_decode(file_get_contents($player_name.".json"), true);
    }
    public static function getPlayerList($base_dir){
        /**
         * Gets a list of players that have joined since Glifcos.
         * @param $base_dir base webserver directory
         * */
        chdir($base_dir."/players");
        $scan = scandir(getcwd());
        $name = array();
        foreach($scan as $filenames){
            $filenames = str_replace(".json", "", $filenames);
            array_push($name, $filenames);
        }
        unset($name[array_search(".", $name)]);
        unset($name[array_search("..", $name)]);
        return $name;
    }
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
        <title>Glifcos - Player Search</title>
    </head>
    <body>
        <?php
        if (!isset($_GET["_search"])){
            return true;
        }
        ?>
        <div class="w3-container">
            <div class="w3-card">
                <header class="w3-container w3-green">
                    <h4 style="font-family: Raleway;">[<?php echo $_GET["_search"] ?>] - Glifcos Player Search</h4>
                </header>
                <div class="w3-container">
                    <br>
                    <a href="<?php echo $_COOKIE["origin-point"] ?>" class="w3-btn-block w3-green">Return To Glifcos</a>
                    <br>
                    <center>
                        <br>
                        <h2><?php echo $_GET["_search"] ?></h2>
                        <?php
                        $data = PlayerData::getPlayerData($_GET["_search"], $_COOKIE["cl"]);
                        if (!$data){
                            echo '
                            <p><font color="red">Player data not found.</font></p>
                            ';
                            goto skip_aroo;
                        }
                        if ($data["is_online"]){
                            $calculation_mins = round(floatval((time()-$data["_recent_time"])/60));
                            echo '
                            <p>Status: <font color="green">Online</font><br>
                            Last Seen: '.$calculation_mins.' minutes ago <small>(Time is rounded)</small><br>
                            Last IP: '.$data["current_ip"].'
                            </p>';
                        }
                        else{
                            echo '
                            <p>Status: <font color="red">Offline</font><br>
                            Last Seen: '.$calculation_mins.' minutes ago <small>(Time is rounded)</small><br>
                            Last IP: '.$data["current_ip"].'
                            </p>';
                        }
                        skip_aroo:
                        ?>
                    </center>
                </div>
            </div>
        </div>
    </body>
</html>