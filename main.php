<?php
/**
 * Created by PhpStorm.
 * User: tomoki
 * Date: 2017/01/12
 * Time: 14:53
 */
require_once './Twig-1.30.0/lib/Twig/Autoloader.php';
require_once './database.php';
require_once './Work.php';

//sessionの開始
/*
 * sessionIDに紐付けるデータの形式
 * array
 * user_id
 * processing (ture or false)
 * work_id
 */
session_start();

//twigに必要な処理
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader,
    array(
    ));

//ログイン判定
//TODO ワークの追加が起きた時やF5が押された時と区別する必要あり
$user_name = $_POST['userName'];
$password = $_POST['userPassword'];
$status = $_GET['status'];
$renderFlag = false;

//データベース用のコネクション
$link = Database::connect();
$selected = Database::selectDatabase($link);

//TODO 定数にする
if($status === '0')
{
    //ログイン画面から
    if(!isset($user_name) || !isset($password))
    {
        //loginページへリダイレクト
        header('Location: login.php');
        exit();
    }
//空の情報がないか
    if($user_name === '' || $password === '')
    {
        //loginページへリダイレクト
        header('Location: login.php');
        exit();
    }
    $query = "SELECT pass, user_id FROM user WHERE user_name=\"{$user_name}\"";
    var_dump($query);
    $result = Database::issue($query);
    $result = mysql_fetch_assoc($result);
    if($result['pass'] === $password)
    {
        //ログイン成功
        $renderFlag = true;
        $temp = $_COOKIE['PHPSESSID'];
        $_SESSION[$temp] = array(
            'user_id' => $result['user_id'],
            'processing' => false,
            'work_id' => '',
        );
    }else{
        //loginページへリダイレクト
        header('Location: login.php');
        exit();
    }
}elseif ($status === '1') {
    //ワークの追加
    var_dump($_POST['usrInput']);
    //sessionが有効でなかったらリダイレクト
    if (!isset($_COOKIE['PHPSESSID'])) {
        //loginページへリダイレクト
        header('Location: login.php');
        exit();
    }
    $temp = $_COOKIE['PHPSESSID'];
    $user_id = $_SESSION[$temp]['user_id'];
    $work_name = $_POST['usrInput'];
    $current_time = date('Y-m-d H:i:s');
    $work = new Work($user_id, $work_name, $current_time, $current_time, ''); //一時的に開始時間と終了時間を一致させておく。最終的に書き換える。
    $result = $work->addToDatabase();
    if (!$result['state']) {
        echo 'データの追加に失敗しました';
    } else {
        $_SESSION[$temp]['processing'] = true;
        $_SESSION[$temp]['work_id'] = $result['id'];
    }
    $renderFlag = true;
}elseif ($status === '2'){
    //TODO 開始時間と終了時間の日付が違ったらそのワークを破棄する
    //ワークが終了
    //sessionが有効でなかったらリダイレクト
    if(!isset($_COOKIE['PHPSESSID']))
    {
        header('Location: login.php');
        exit();
    }
    //対象ワークの終了時間の変更
    $temp = $_COOKIE['PHPSESSID'];
    $work_id = $_SESSION[$temp]['work_id'];
    $current_time = date('Y-m-d H:i:s');
    $query = sprintf("UPDATE work SET end_time=\"%s\" WHERE work_id=%d", $current_time, $work_id);
    $result = Database::issue($query);
    if(!$result)
    {
        echo 'データの更新に失敗しました';
    }else{
        $_SESSION[$temp]['processing'] = false;
        $_SESSION[$temp]['work_id'] = null;
    }
    $renderFlag = true;
}
//F5や直接アクセスされた時
if(!isset($_COOKIE['PHPSESSID']))
{
    //loginページへリダイレクト
    header('Location: login.php');
    exit();
}
$renderFlag = true;

//対象のワークの取得
$session_id = $_COOKIE['PHPSESSID'];
$user_id = $_SESSION[$temp]['user_id'];
if(!isset($_POST['dateInput']) || $_POST['dateInput'] === '')
{
    $targetStartDate = date("Y-m-d H:i:s");
    $targetStartDate = explode(" ",$targetStartDate)[0]. ' 00:00:00';
    $targetEndDate = explode(' ', $targetStartDate)[0]. '23:59:59';
}else{
    //時刻が指定された
    $targetDate = $_POST['dateInput'];
    $targetDate = explode('/', $targetDate);
    $targetDate = "{$targetDate[0]}-{$targetDate[1]}-{$targetDate[2]} 00:00:00";
    $targetEndDate = explode(' ', $targetStartDate)[0]. ' 23:59:59';
}

$query = sprintf("SELECT * FROM work WHERE start_time>=\"%s\" AND end_time<=\"%s\" AND user_id=%d", $targetStartDate, $targetEndDate, $user_id);
$result = Database::issue($query);
$works = array();
if(!$result)
{
    echo 'データの取得に失敗しました';
}else{
    while ($row = mysql_fetch_assoc($result))
    {
        $work = new Work($row['user_id'], $row['work_name'], $row['start_time'], $row['end_time'], '');
        array_push($works, $work->toArray());
    }
}

if($renderFlag)
{
    $temp = $_COOKIE['PHPSESSID'];
    //指定された日時のワークを取得

    $template = $twig->load('main.twig');
    echo $template->render(array(
        'processing' => $_SESSION[$temp]['processing'],
        'works' => $works,
    ));
}
?>