<?
    require_once '../nav/mysql.php';
    require_once '../nav/constants.php';

    session_start();

    $mysql = new Mysql();

    $month = $_GET['month'];
    $list =  $_GET['list'];

    $mysql->makeListDownload('emails.txt', $month, $list);
?> 