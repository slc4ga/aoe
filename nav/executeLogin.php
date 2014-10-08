<?php
require_once 'mysql.php';
$mysql = new Mysql();
    // login
    $er = "";
    if(!empty($_POST['un'])) {
        if(!empty($_POST['pw'])) {
            $er = $mysql->login($_POST['un'], $_POST['pw']);
            //echo "error: " . $er . "<br>";
            if(strlen($er) == 0) {
                if($_POST['remember']) {
                    setcookie('remember_me', $_POST['un'], $year);
                }
                elseif(!$_POST['remember']) {
	               if(isset($_COOKIE['remember_me'])) {
                              $past = time() - 100;
		              setcookie(remember_me, gone, $past);
                       }
                }

                //redirect
                //echo "stop";
                header("location: ../users/userHome.php");
            } else {
                $header = "location: loginRetry.php?er=" . $er;
                header("$header");
            }
        }
    }
?>