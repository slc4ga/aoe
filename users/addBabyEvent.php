<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location:../index.php");
    }

    $date = $_POST['date'];
    $name = $_POST['name'];
    $category = $_POST['cat'];
    
    $mysql->addBabyEvent($name, $date, $category);
    header("location: userHome.php?select=6&event=success");

?>