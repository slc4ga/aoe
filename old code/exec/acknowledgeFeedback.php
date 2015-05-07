<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $req = $_GET['req'];

    if(isset($req)) {
        $mysql->acknowledgeFeedback($req);
        header("location: exec.php?select=6");
    }

?>