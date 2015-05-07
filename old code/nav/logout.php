<?
    session_start();
    unset($_SESSION["user_id"]);  
    unset($_SESSION["resetPass"]);
    header("Location: ../index.php");
?>