<?
    include_once '../nav/mysql.php';
    session_start();

    $mysql = New Mysql();
    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


    if($_POST && isset$_POST['year']) {
        $activities = $_POST['activities'];
        $array = explode("\n", $activities);
        $mysql->updateProfile($_POST['year'], $_POST['hometown'], $_POST['country'], $_POST['major'], $_POST['major2'], 
                              $_POST['minor'], $_POST['minor2'], $_POST['activities'], $_POST['bio']);  
        header("location:userHome.php");
    }
?>