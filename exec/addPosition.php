<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $name = $_GET['name'];
    $order = $_GET['order'];
    
    $mysql->addLeaderPosition($name, $order);

    header("location: exec.php?select=3&pos=added");

?>