<?
    require_once '../nav/mysql.php';
    require_once '../nav/constants.php';

    $mysql = new Mysql();
    session_start();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $cbnames=array_keys($_POST);
    if(count($cbnames) != 0) {
       $id_numbers=array();
       foreach($cbnames as &$val) {
          if (isset($_POST[$val])) {
              // delete sister
              $str = substr($val, 2);
              if($str != 'lete') {
                    $mysql->deleteSister($str);
              }
          }
       }
        header("location:webmaster.php?select=2");
    }
?>