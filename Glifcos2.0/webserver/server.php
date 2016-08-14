<?php

class Glifcos {
    public static function isPingExist(){
        return is_file("database/ping.txt");
    }
    public static function isRAMExist(){
        return is_file("database/ram.txt");
    }
    public static function isConsoleExist(){
        return is_file("database/console.txt");
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
    public static function createAccessToken($token){
        if (!self::isDatabaseExist()){
            return false;
        }
        else{
            $time = time();
            $data = self::getDatabase();
            if (!array_key_exists("tokens", $data)){
                $data["tokens"] = array();
            }
            $data["tokens"][$token] = $time;
            self::writeDatabase($data);
            return true;
        }
    }
    public static function verifyAccessToken($token){
        if (!self::isDatabaseExist()){
            return false;
        }
        else{
            $time = time();
            $data = self::getDatabase();
            if (!array_key_exists($token, $data["tokens"])){
                return false;
            }
            else{
                $time2 = $data["tokens"][$token];
                $distance = intval($time - $time2);
                
                // quickly clean out other tokens as well..
                foreach($data["tokens"] as $f => $tokens){
                    $distance_2 = intval($time - $tokens);
                    if ($distance_2 >= 1800){
                        unset($data["tokens"][$f]);
                    }
                }
                
                if ($distance >= 1800){
                    // greater than 30 minutes.
                    unset($data["tokens"][$token]);
                    self::writeDatabase($data);
                    return false;
                }
                else{
                    // less than 30 minutes.
                    return true;
                }
            }
        }
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
elseif ($request === "GetRAMGlifcos"){
    // Call this POST request to get the RAM data.
    if (!Glifcos::isRAMExist()){
        echo null;
        return;
    }
    echo base64_decode(file_get_contents("database/ram.txt"));
}
elseif ($request === "GetConsoleGlifcos"){
    // Call this POST request to get the console data.
    if (!Glifcos::isConsoleExist()){
        echo null;
        return;
    }
    echo base64_decode(file_get_contents("database/console.txt"));
}
elseif ($request === "GetServerOnline"){
    echo true;
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
elseif ($request === "AddConsoleCommand"){
    // Call this POST to add a command to be sent in console.
    $command = $_POST["command"];
    $data = array();
    if (is_file("database/commands.txt")){
        $data = json_decode(base64_decode(file_get_contents("database/commands.txt")), true);
        unlink("database/commands.txt");
    }
    array_push($data, $command);
    $h = fopen("database/commands.txt", "w+");
    fwrite($h, base64_encode(json_encode($data)));
    fclose($h);
}
elseif ($request === "LoginAdminAccount"){
    // Call this POST to verify a login on Glifcos.
    $username = $_POST["username"];
    $password = $_POST["password"];
    $login_array = array("correct" => false);
    if (!Glifcos::isDatabaseExist()){
        echo json_encode($login_array);
        return;
    }
    else{
        $data = Glifcos::getDatabase();
        if (!array_key_exists($username, $data["users"])){
            echo json_encode($login_array);
            return;
        }
        if (!password_verify($password, $data["users"][$username])){
            echo json_encode($login_array);
            return;
        }
        else{
            $login_array["correct"] = true;
            $login_array["username"] = $username;
            $login_array["ACCESS_TOKEN"] = uniqid();
            Glifcos::createAccessToken($login_array["ACCESS_TOKEN"]);
            echo json_encode($login_array);
            return;
        }
    }
}
elseif ($request === "VerifyAccessToken"){
    // Call this POST to verify if an access token is valid.
    // Returns true if access token is valid, false otherwise.
    if (!Glifcos::verifyAccessToken($_POST["token"])){
        echo false;
    }
    else{
        echo true;
    }
}
elseif ($request === "SimplePingGlifcos"){
    // Client server POST, sends a basic ping status.
    unlink("database/ping.txt");
    $t = fopen("database/ping.txt", "w+");
    fwrite($t, base64_encode(json_encode($_POST)));
    fclose($t);
}
elseif ($request === "SimpleRAMGlifcos"){
    // Client server POST, sends a RAM update.
    unlink("database/ram.txt");
    $t = fopen("database/ram.txt", "w+");
    fwrite($t, base64_encode(json_encode($_POST)));
    fclose($t);
}
elseif ($request === "SimpleConsoleGlifcos"){
    // Client server POST, sends a console update.
    unlink("database/console.txt");
    $t = fopen("database/console.txt", "w+");
    fwrite($t, base64_encode(json_encode($_POST)));
    fclose($t);
}
elseif ($request === "SimplePlayerGlifcos"){
    // Client server POST, sends a player update.
    unlink("database/players.txt");
    $t = fopen("database/players.txt", "w+");
    fwrite($t, base64_encode(json_encode($_POST)));
    fclose($t);
}
elseif ($request === "GotConsoleCommand"){
    // Client server POST, lets us know they've recieved the commands.
    $h = fopen("database/commands.txt", "w+");
    fwrite($h, base64_encode(json_encode(array())));
    fclose($h);
    echo $data;
}