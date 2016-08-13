<?php

class Glifcos {
    public static function isPingExist(){
        return is_file("database/ping.txt");
    }
    public static function isDatabaseExist(){
        return is_file("database/config.txt");
    }
    public static function getDatabase(){
        return json_decode(base64_decode(file_get_contents("database/config.txt")), true);
    }
    public static function writeDatabase($data){
        if (is_file("database/config.txt")){
            unlink("database/config.txt");
        }
        $d = fopen("database/config.txt", "w+");
        fwrite($d, base64_encode(json_encode($data)));
        fclose($d);
    }
}

$request = $_POST["request"];

if ($request === null){
    return;
}
elseif ($request === "getGlifcosState"){
    // Call this POST request to get the Glifcos setup state.
    /*
    1 = Not setup,
    2 = Already setup
    */
    if (!Glifcos::isDatabaseExist()){
        echo 1;
    }
    else{
        echo 2;
    }
}
elseif ($request === "GetPingGlifcos"){
    // Call this POST request to get the ping data.
    if (!Glifcos::isPingExist()){
        echo null;
        return;
    }
    echo base64_decode(file_get_contents("database/ping.txt"));
}
elseif ($request === "AddAdminAccount"){
    // Call this POST to make a new account on Glifcos.
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (!Glifcos::isDatabaseExist()){
        $data = array("users" => array($username => password_hash($password, PASSWORD_DEFAULT)));
    }
    else{
        $data = Glifcos::getDatabase();
        $data["users"][$username] = password_hash($password, PASSWORD_DEFAULT);
    }
    Glifcos::writeDatabase($data);
}
elseif ($request === "SimplePingGlifcos"){
    // Client server POST, sends a basic ping status.
    $t = fopen("database/ping.txt", "w+");
    fwrite($t, base64_encode(json_encode($_POST)));
    fclose($t);
}