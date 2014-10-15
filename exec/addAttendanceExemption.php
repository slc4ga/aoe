<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $date = $_POST['date'];
    $sister = $_POST['sister'];
    
    $mysql->chapterExemption($sister, $date);
    header("location: exec.php?exempt=success");

?>