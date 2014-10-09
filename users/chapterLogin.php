<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $username = $_GET['username'];
    $date = $_GET['date'];
    $pw = $_GET['password'];
    $ontime = $_GET['ontime'];

    echo $mysql->attendChapter($username, $date, $pw, $ontime);
?>