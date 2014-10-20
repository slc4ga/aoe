<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

	$name = $_GET['name'];
    $id = $_GET['id'];
    $pc = $_GET['pc'];

    $mysql->addSister($name, $id, $pc);
    
    $header = "location: classMembers.php?class=" . $pc;
    header($header);
?>