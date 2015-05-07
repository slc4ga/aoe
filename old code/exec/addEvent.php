<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $date = $_POST['date'];
    $name = $_POST['name'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    
    $mysql->addEvent($name, $date, $points, $category);
    header("location: exec.php?add=success");

?>