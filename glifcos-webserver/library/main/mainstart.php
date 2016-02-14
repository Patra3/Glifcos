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
<!-- <div class="w3-container"> -->
<br>
<?php
require $_COOKIE["cl"]."/library/ceoperands/grabr.php";
require $_COOKIE["cl"]."/library/main/guardian.php";

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
setcookie("origin-point", curtPageURL());
?>
<div class="w3-card-4" style="width:100%;">
<header class="w3-container w3-blue">
  <h1 style="font-family: Raleway, Serif;">Status</h1>
</header>
<div class="w3-container">
    <br>
    <center>
    <span class="w3-tag w3-sm w3-padding-large w3-blue w3-tooltip">
    <i class="fa fa-users"></i> <?php
    echo grabr::getCurrentPlayerAM($_COOKIE["cl"])."/".grabr::getTotalPlayers($_COOKIE["cl"]);
    ?> players online <br>
    <span class="w3-text">[<?php
    if (empty(grabr::getPlayerList($_COOKIE["cl"]))){
      echo "No players!";
    }
    else{
      foreach (grabr::getPlayerList($_COOKIE["cl"]) as $name){
        echo $name.", ";
      }
    }
    ?>]</span></span>
    <span class="w3-tag w3-sm w3-padding-large w3-<?php
    $serv = grabr::isServerOnline($_COOKIE["cl"]);
    if (!$serv){
      echo "red";
    }
    else{
      echo "green";
    }
    ?>"><?php
    $serv = grabr::isServerOnline($_COOKIE["cl"]);
    if ($serv){
      echo '<i class="fa fa-check"></i> ';
    }
    else{
      echo '<i class="fa fa-exclamation-triangle"></i> ';
    }
    ?>Server is <?php
    $serv = grabr::isServerOnline($_COOKIE["cl"]);
    if (!$serv){
      echo "Offline";
    }
    else{
      echo "Online";
    }
    ?></span>
    <span class="w3-tag w3-sm w3-padding-large w3-indigo">
    <i class="fa fa-cogs"></i> <?php
    echo grabr::getPMBuild($_COOKIE["cl"]);
    ?></span>
    <span class="w3-tag w3-sm w3-padding-large w3-white"></span>
    </center>
</div>
</div>
<br>
<div class="w3-card-4" style="width:100%;">
<header class="w3-container w3-red">
  <h1 style="font-family: Raleway, Serif;">CPU</h1>
</header>
<div class="w3-container">
    <center>
        <h2 style="font-family: Raleway, Serif;"><?php
        echo grabr::getCurrentCPU($_COOKIE["cl"]);
        ?>% usage</h2>
    </center>
</div>
</div>
<br>
<div class="w3-card-4" style="width:100%;">
<header class="w3-container w3-<?php
$calc = round(grabr::getCurrentMemory($_COOKIE["cl"])/grabr::getTotalMemory($_COOKIE["cl"]) * 100);
if ($calc <= "25"){
  echo "green";
}
elseif ($calc <= "75"){
  echo "yellow";
}
elseif ($calc <= "100"){
  echo "red";
}
?>">
  <h1 style="font-family: Raleway, Serif;">RAM</h1>
</header>
<div class="w3-container">
    <center>
        <h2 style="font-family: Raleway, Serif;"><?php
        // Short hack to fix information grab issues.
        if (empty(grabr::getCurrentMemory($_COOKIE["cl"]))){
          echo '
          <script>location.reload();</script>
          ';
        }
        if (empty(grabr::getTotalMemory($_COOKIE["cl"]))){
          echo '
          <script>location.reload();</script>
          ';
        }
        echo round(grabr::getCurrentMemory($_COOKIE["cl"])/grabr::getTotalMemory($_COOKIE["cl"]) * 100);
        ?>% usage</h2>
        <p><?php
        echo grabr::getCurrentMemory($_COOKIE["cl"])."/".grabr::getTotalMemory($_COOKIE["cl"]);
        ?> MB</p>
    </center>
</div>
</div>
<br>
<!-- MANAGEMENT OPTIONS BUTTON -->
<div class="w3-card-4" style="width:100%;">
<header class="w3-container w3-deep-purple">
  <h1 style="font-family: Raleway, Serif;">Management Actions</h1>
</header>
<div class="w3-container">
    <center>
        <br>
        <div class="w3-dropdown-hover">
          <button class="w3-btn w3-red">Server</button>
          <div class="w3-dropdown-content w3-border">
            <a onclick="document.getElementById('id01').style.display='block'">
              <i class="fa fa-terminal"></i> 
              Console
            </a>
            <a onclick="document.getElementById('id02').style.display='block'">
              <i class="fa fa-plug"></i> 
              Plugins
            </a>
            <a href="filemanager/mainfile.php">
              <i class="fa fa-file"></i> 
              File Manager
            </a>
            <a href="CONTROL.php?task=stop">
              <i class="fa fa-stop-circle"></i> 
              Stop
            </a>
            <a href="CONTROL.php?task=reload">
              <i class="fa fa-backward"></i> 
              Reload
            </a>
          </div>
        </div>
    </center>
</div>
<br>
</div>
<!-- SERVER CONSOLE MODAL -->
<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'" 
      class="w3-closebtn">&times;</span>
      <br>
      <a name="outtake"></a>
      <a class="w3-btn w3-tiny w3-blue" href="#intake">Go to bottom</a>
      <div class="w3-code htmlHigh">

        <?php
        echo str_replace("\n", "<br>", substr(grabr::getConsole($_COOKIE["cl"]), -10000));
        ?>
        
      </div>
      <a name="intake"></a>
      <form class="w3-container" 
      action="consolesender.php" method="post">
        <p> 
        <label class="w3-label">Console Input</label>
        <input class="w3-input" type="text" name="input"></p>
      </form>
      <br>
      <a class="w3-btn w3-tiny w3-blue" href="#outtake">Go to top</a>
      <a class="w3-btn w3-tiny w3-blue" href="consolesender.php?ref=reload">
        Reload Console Data
      </a>
    </div>
  </div>
</div>
<!-- PLUGIN MODAL -->
<div id="id02" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container">
      <span onclick="document.getElementById('id02').style.display='none'" 
      class="w3-closebtn">&times;</span>
      <h4 style="font-family: Raleway, Serif;">Manage Your Plugins</h4>
      <?php
      foreach(grabr::getPlugins($_COOKIE["cl"]) as $lols){
        if ((grabr::isPluginEnabled($_COOKIE["cl"], $lols)) === false){
          $status = "Disabled";
          $color = "deep-orange";
        }
        else{
          $status = "Enabled";
          $color = "green";
        }
        echo '
        <div class="w3-dropdown-hover">
          <button class="w3-btn w3-red">'.$lols.' <span class="w3-tag w3-'.$color.'">'.$status.'</span></button>
          <div class="w3-dropdown-content w3-border">
            <a href="pluginse.php?trans=disable&plugin='.$lols.'">Disable Plugin</a>
            <a href="pluginse.php?trans=enable&plugin='.$lols.'">Enable Plugin</a>
            <a href="#">View Data</a>
          </div>
        </div>
        ';
      }
      ?>
    </div>
  </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!-- </div> -->