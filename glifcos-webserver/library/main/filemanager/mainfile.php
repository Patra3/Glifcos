<?php ob_start(); ?>
<html>
    <head>
        <!-- W3 CSS -->
        <link rel="stylesheet" href="w3.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- COMPAT -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Glifcos - File Manager</title>
    </head>
    <body>
        <div class="w3-container">
            <br>
            <div class="w3-card-4" style="width:100%">
                <header class="w3-container w3-purple">
                  <h1>Glifcos - File Manager</h1>
                </header>
                <div class="w3-container">
                    <?php
                    require $_COOKIE["cl"]."/library/ceoperands/talk.php";
                    if (!isset($_COOKIE["curflags"])){
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
                            echo '
                            <br>
                            <div class="w3-card-4" style="width:100%">
                            <header class="w3-container w3-blue">
                                <h1><i class="fa fa-folder-o"></i> Folder</h1>
                            </header>
                            <div class="w3-container">
                            <p>Name: '.$ds["name"].'</p>
                            </div>
                            <footer class="w3-container w3-blue">
                                <a class="w3-btn w3-indigo" href="#">Browse</a>
                                <a class="w3-btn w3-indigo" href="#">Delete</a>
                                <a class="w3-btn w3-indigo" href="#">Rename</a>
                                <a class="w3-btn w3-indigo" href="#">Move</a>
                                <a class="w3-btn w3-indigo" href="#">Copy</a>
                            </footer>
                            </div>
                            ';
                        }
                        elseif ($ds["type"] === "file"){
                            // === MODAL FOR DISPLAYING FILE CARD ===
                            echo '
                            <br>
                            <div class="w3-card-4" style="width:100%">
                            <header class="w3-container w3-blue">
                                <h1><i class="fa fa-file"></i> File</h1>
                            </header>
                            <div class="w3-container">
                            <p>Name: '.$ds["instantname"].'</p>
                            </div>
                            <footer class="w3-container w3-blue">
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                '\').style.display=\'block\'">View</a>
                                <a class="w3-btn w3-indigo" onclick="
                                document.getElementById(\''.base64_encode($ds["instantname"]).
                                'edit\').style.display=\'block\'">Edit</a>
                                <a class="w3-btn w3-indigo" href="#">Delete</a>
                                <a class="w3-btn w3-indigo" href="#">Rename</a>
                                <a class="w3-btn w3-indigo" href="#">Move</a>
                                <a class="w3-btn w3-indigo" href="#">Copy</a>
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
                                  <form class="w3-container" action="trsedit.php" method="get">
                                    <p>
                                    <textarea rows="20" cols="80" name="">
                                    '.$ds["data"].'
                                    </textarea>
                                    </p>
                                    <input type="submit" class="w3-btn w3-blue" value="Save">
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
    </body>
</html>
<?php ob_end_flush(); ?>