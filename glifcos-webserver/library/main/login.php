<?php
if (isset($_POST["user"])){
    $pass = $_POST["pwds"];
    
    require $_COOKIE["cl"]."/library/ceoperands/usermgr.php";
    
    $verify = usermgr::loginUser($_POST["user"], $pass, $_COOKIE["cl"]);
    if ($verify){
        setcookie("Authchain", base64_encode(json_encode(array("user" =>
        $_POST["user"], "pass" => $_POST["pwds"], "authed" => "yas"))));
        setcookie("setup", "", time());
        echo '<script>
        window.location = "hack_screen.php";
        </script>
        ';
    }
    else{
        echo "boo!";
    }
}