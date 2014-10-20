<?
    require_once '../nav/mysql.php';
    require_once '../nav/constants.php';

    $mysql = new Mysql();
    session_start();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $eventId = $_POST['eventID'];

    $cbnames=array_keys($_POST);
    if(count($cbnames) != 0) {
       $id_numbers=array();
       foreach($cbnames as &$val) {
          if (isset($_POST[$val])) {
              // delete sister
              $str = substr($val, 2);
              if($str != 'entID') {
                    $mysql->approveAttendance($eventId, $str);
              }
          }
       }
        header("location:exec.php?approve=success");
    }
?>