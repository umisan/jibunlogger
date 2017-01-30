<?php
/**
 * Created by PhpStorm.
 * User: umino
 * Date: 17/01/28
 * Time: 15:54
 */
require_once './database.php';

//サインアップ処理を行う
$user_name = $_POST['userName'];
$pass = $_POST['userPassword'];
$sleep_time = $_POST['sleepTime'];
$wakeup_time = $_POST['wakeupTime'];

function back()
{
    header('Location: signup.php');
    exit();
}

echo "kokomade";

if(!isset($user_name) || !isset($pass) || !isset($sleep_time) || !isset($wakeup_time))
{
    back();
}else if($user_name === '' || $pass === '' || $sleep_time === '' || $wakeup_time === '')
{
    back();
}

//すべての入力がオッケー
$link = Database::connect();
Database::selectDatabase($link);

$query = sprintf("INSERT INTO user(user_name, pass, sleep_time, wakeup_time) VALUES(\"%s\", \"%s\", \"%s\", \"%s\")",
    $user_name, $pass,  $sleep_time, $wakeup_time);
var_dump($query);
$result = Database::issue($query);
if($result)
{
    header('Location: login.php');
    exit();
}else{
    back();
}
?>