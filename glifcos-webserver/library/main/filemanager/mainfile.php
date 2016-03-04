<?php 
require $_COOKIE["cl"]."/library/main/guardian.php";
ob_start(); ?>
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
        <script>
            function quick(file_with_flags){
                document.cookie = "filedelname="+file_with_flags+";";
                window.location = "trsedit.php?rf=delete";
            }
        </script>
        <!-- CUSTOM RALEWAY FONT -->
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
        <title>Glifcos - File Manager</title>
    </head>
    <body <?php 
    
    if (isset($_GET["rf"])){
        if ($_GET["rf"] === "filechanged"){
            echo 'onload="document.getElementById(\'filechanged\').style.display=\'block\'"';
        }
        elseif ($_GET["rf"] === "filedelled"){
            echo 'onload="document.getElementById(\'filedelled\').style.display=\'block\'"';
        }
        elseif ($_GET["rf"] === "filerenamed"){
            echo 'onload="document.getElementById(\'filerenamed\').style.display=\'block\'"';
        }
        elseif ($_GET["rf"] === "filemoved"){
            echo 'onload="document.getElementById(\'filemoved\').style.display=\'block\'"';
        }
        elseif ($_GET["rf"] === "filecopied"){
            echo 'onload="document.getElementById(\'filecopied\').style.display=\'block\'"';
        }
        elseif ($_GET["rf"] === "creationac"){
            echo 'onload="document.getElementById(\'creationac\').style.display=\'block\'"';
        }
    }
    else{
      if (!isset($_COOKIE["trialt"])){
        setcookie("trialt", "tb", time() + 1800);
        echo 'onload="document.getElementById(\'trialnotice\').style.display=\'block\'"';
      }
    }
    ?> style="font-family: Raleway, Serif">
        <!-- NOTIFICATIONS FOR FILE PLACEMENTS -->
        <div id="filechanged" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('filechanged').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> File saved successfully!</p>
            </div>
          </div>
        </div>
         <div id="filedelled" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('filedelled').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> File deleted successfully!</p>
            </div>
          </div>
        </div>
         <div id="filerenamed" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('filerenamed').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> File renamed successfully!</p>
            </div>
          </div>
        </div>
         <div id="filemoved" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('filemoved').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> File moved successfully!</p>
            </div>
          </div>
        </div>
         <div id="filecopied" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('filecopied').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> File copied successfully!</p>
            </div>
          </div>
        </div>
        <div id="trialnotice" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('trialnotice').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p>
                <i class="fa fa-exclamation-triangle"></i><br>
                Glifcos - File Manager is currently in beta testing.<br>
                File managing features work successfully, and can be used <br>
                in a careful manner.
                <br>
                Note that large or excessive directories may crash the file <br>
                manager. The file manager's performance may be sluggish <br>
                as it connects directly to the client server. <br>
                <br>
                Please generally be gentle with the file manager, and you'll <br>
                have a great experience. Enjoy!
              </p>
            </div>
          </div>
        </div>
         <div id="creationac" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('creationac').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <p style="color: green;"><i class="fa fa-file-o"></i> Successfully created!</p>
            </div>
          </div>
        </div>
        <!-- END OF DAT -->
        
        <!-- FOR NEW FOLDER & FILES -->
        <div id="newfile" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('newfile').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <form class="w3-container" action="trsedit.php" method="post">
                <p>
                <label>Name of File</label>
                <input class="w3-input" type="text" name="finame"></p>
              </form>
            </div>
          </div>
        </div>
        <div id="newfolder" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('newfolder').style.display='none'" 
              class="w3-closebtn">&times;</span>
              <form class="w3-container" action="trsedit.php" method="post">
                <p>
                <label>Name of Folder</label>
                <input class="w3-input" type="text" name="fname"></p>
              </form>
            </div>
          </div>
        </div>
        <!-- END OF DAT TOO -->
        
        <div class="w3-container">
            <br>
            <div class="w3-card-4" style="width:100%">
                <header class="w3-container w3-purple">
                  <h1 style="font-family: Raleway, Serif;">Glifcos - File Manager</h1>
                </header>
                <div class="w3-container">
                    <?php
                    require $_COOKIE["cl"]."/library/ceoperands/talk.php";
                    if (isset($_COOKIE["curflags"])){
                        if ($_COOKIE["curflags"] != "/"){
                            echo '
                            <br>
                            <button class="w3-btn w3-blue" onclick=" window.location=
                            \'trsedit.php?remove=removelayerflag\'; ">Go back</button>
                            <br>
                            ';
                        }
                    }
                    echo '
                    <br>
                    <button class="w3-btn w3-blue" style="display: inline-block;" 
                    onclick="document.getElementById(\'newfile\').style.display=\'block\'"
                    >New File</button>
                    <button class="w3-btn w3-blue" style="display: inline-block;" 
                    onclick="document.getElementById(\'newfolder\').style.display=\'block\'"
                    >New Folder</button>
                    <br>
                    <br>
                    <a href="'.$_COOKIE["origin-point"].'" 
                    class="w3-btn w3-blue">
                    Back to Glifcos</a>
                    <br>';
                    if (empty($_COOKIE["curflags"])){
                        setcookie("curflags", "/");
                    }
                    $data = talk::requestFileData(1, $_COOKIE["curflags"], $_COOKIE["cl"]);
                    // removes the dot (. , ..) directories.
                    $key1 = array_search(array("type" => "dir", "name" => "."), $data);
                    $key2 = array_search(array("type" => "dir", "name" => ".."), $data);
                    unset($data[$key1]);
                    unset($data[$key2]);
                    //
                    
                    foreach ($data as $ds){
                        if ($ds["type"] === "dir"){
                            // === MODAL FOR FOLDERS ===
                            echo '
                            <br>
                            <div class="w3-card" style="width:100%">
                            <header class="w3-container w3-blue">
                                <h1 style="font-family: Raleway, Serif;"><i class="fa fa-folder-o"></i> Folder</h1>
                            </header>
                            <div class="w3-container">
                            <p>Name: '.$ds["name"].'</p>
                            </div>
                            <footer class="w3-container w3-blue">
                                <a class="w3-btn w3-indigo" href="trsedit.php?addflag='.
                                $ds["name"].'">Browse</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["name"]).
                                'delete\').style.display=\'block\'">Delete</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["name"]).
                                'rename\').style.display=\'block\'">Rename</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["name"]).
                                'move\').style.display=\'block\'">Move</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["name"]).
                                'copy\').style.display=\'block\'">Copy</a>
                            </footer>
                            </div>
                            ';
                            // === MODAL FOR RENAMING FOLDERS ===
                            echo '
                            <div id="'.base64_encode($ds["name"]).'rename" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["name"]).
                                  'rename\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Rename Folder</label>
                                    <input class="w3-input" type="text" name="rename"
                                     value="'.$ds["name"].'"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Rename" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["name"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR DELETING FOLDERS ===
                            echo '
                            <div id="'.base64_encode($ds["name"]).'delete" class="w3-modal">
                              <div class="w3-modal-content">
                                <header class="w3-container w3-red">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["name"]).
                                  'delete\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;
                                  </span>
                                  <p><i class="fa fa-exclamation-circle"></i> Are you sure? Deleting a folder is permanent!</p>
                                </header>
                                <div class="w3-container">
                                  <br>
                                  <button class="w3-btn w3-red" onclick=\'quick("'.$_COOKIE["curflags"].
                                  $ds["name"].'");\'>Delete</button>
                                  <br>
                                  <br>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR COPYING FOLDERS ===
                            echo '
                            <div id="'.base64_encode($ds["name"]).'copy" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["name"]).
                                  'copy\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Copy to directory</label>
                                    <input class="w3-input" type="text" name="copydir"
                                     value="/"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Copy" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["name"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR MOVING FOLDERS ===
                            echo '
                            <div id="'.base64_encode($ds["name"]).'move" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["name"]).
                                  'move\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Move to directory</label>
                                    <input class="w3-input" type="text" name="movedir"
                                     value="/"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Move" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["name"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                        }
                        elseif ($ds["type"] === "file"){
                            // === MODAL FOR DISPLAYING FILE CARD ===
                            echo '
                            <br>
                            <div class="w3-card" style="width:100%">
                            <header class="w3-container w3-blue">
                                <h1 style="font-family: Raleway, Serif;"><i class="fa fa-file"></i> File</h1>
                            </header>
                            <div class="w3-container">
                            <p>Name: '.$ds["instantname"].'</p>
                            <p>Last Modified: '.$ds["lastmodded"].'</p>
                            <p>Extension: '.$ds["ext"].'</p>
                            <p>Size: '.$ds["size"].' bytes</p>
                            </div>
                            <footer class="w3-container w3-blue">
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                '\').style.display=\'block\'">View</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'edit\').style.display=\'block\'">Edit</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'delete\').style.display=\'block\'">Delete</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'rename\').style.display=\'block\'">Rename</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'move\').style.display=\'block\'">Move</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'copy\').style.display=\'block\'">Copy</a>
                            </footer>
                            </div>
                            ';
                            // === MODAL FOR VIEWING FILE ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  '\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <br>
                                  '.str_replace("\n", "<br>", $ds["data"]).'
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR EDITING FILE w. FORM ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'edit" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  'edit\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <br>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <textarea class="w3-input" 
                                    rows="20" cols="80" name="sthap">
                                    '.$ds["data"].'
                                    </textarea>
                                    </p>
                                    <input type="submit" class="w3-btn w3-blue" value="Save" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["instantname"].';\'">
                                  </form>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR DELETING FILE ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'delete" class="w3-modal">
                              <div class="w3-modal-content">
                                <header class="w3-container w3-red">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  'delete\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;
                                  </span>
                                  <p><i class="fa fa-exclamation-circle"></i> Are you sure? Deleting a file is permanent!</p>
                                </header>
                                <div class="w3-container">
                                  <br>
                                  <button class="w3-btn w3-red" onclick=\'quick("'.$_COOKIE["curflags"].
                                  $ds["instantname"].'");\'>Delete</button>
                                  <br>
                                  <br>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR RENAMING FILE ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'rename" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  'rename\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Rename File</label>
                                    <input class="w3-input" type="text" name="rename"
                                     value="'.$ds["instantname"].'"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Rename" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["instantname"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR MOVING FILE ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'move" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  'move\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Move to directory</label>
                                    <input class="w3-input" type="text" name="movedir"
                                     value="/"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Move" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["instantname"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                            // === MODAL FOR COPYING FILES ===
                            echo '
                            <div id="'.base64_encode($ds["instantname"]).'copy" class="w3-modal">
                              <div class="w3-modal-content">
                                <div class="w3-container">
                                  <span onclick="document.getElementById(\''.
                                  base64_encode($ds["instantname"]).
                                  'copy\').style.display=\'none\'" 
                                  class="w3-closebtn">&times;</span>
                                  <form class="w3-container" action="trsedit.php" method="post">
                                    <p>
                                    <label>Copy to directory</label>
                                    <input class="w3-input" type="text" name="copydir"
                                     value="/"></p>
                                    <input type="submit" class="w3-btn w3-blue" value="Move" onclick="
                                    document.cookie =\'filenme='.$_COOKIE["curflags"].
                                    $ds["instantname"].';\'">
                                   </form>
                                </div>
                              </div>
                            </div>
                            ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <br>
    </body>
</html>
<?php ob_end_flush(); ?>