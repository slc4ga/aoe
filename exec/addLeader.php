<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $pos = $_GET['pos'];
    $name = $_GET['sister'];
    
    $mysql->addLeader($pos, $name);

?>