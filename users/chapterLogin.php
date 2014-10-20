<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();
    date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id']) ) {
        header("location:../index.php");
    }

    $username = $_GET['username'];
    $date = $_GET['date'];
    $pw = $_GET['password'];
    $ontime = $_GET['ontime'];

    echo $mysql->attendChapter($username, $date, $pw, $ontime);
?>