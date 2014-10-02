<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

	$class = $_GET['class'];

    $mysql->convertClass($class);
?>