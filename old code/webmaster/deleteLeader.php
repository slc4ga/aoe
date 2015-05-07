<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();
    
    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $pos = $_GET['pos'];
    $name = $_GET['sister'];
    
    $mysql->deleteLeader($pos, $name);

?>