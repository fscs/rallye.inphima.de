<?php

define('BASEPATH','bla');

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

include 'application/config/database.php';
$mysqli = new mysqli($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);

$res = $mysqli->query("SELECT * FROM jd_rallye_games");
$stmt = $mysqli->prepare("INSERT INTO jd_rallye_user (username,password,group_id,active,admin) VALUES (?,?,?,?,?)");
$stmt->bind_param('ssiii',$name,$password,$gameID,$active,$admin);
$active = 1;
while ($row = $res->fetch_assoc()) {
	$gameID = $row['id'];
	$name = $row['name'];
	$password = generatePassword();
	echo $name . " : ".$password."\n";
	$password = hash('sha256',$password);
	$admin = 0;
	$stmt->execute();
}

$gameID = 0;
$name = "admin";
$password = generatePassword();
$admin = 1;
echo $name . " : ".$password."\n";
$password = hash('sha256',$password);
$stmt->execute();
