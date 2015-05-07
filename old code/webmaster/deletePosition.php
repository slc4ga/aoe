<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $name = $_GET['name'];
    
    $mysql->deleteLeaderPosition($name);

    header("location: webmaster.php?select=3&pos=deleted");

?>