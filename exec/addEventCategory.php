<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) == 1 || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $category = $_POST['name'];
    $order = $_POST['order'];
    
    $mysql->addEventCategory($category, $order);
    header("location: exec.php");

?>