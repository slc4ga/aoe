<?
    require_once('../nav/mysql.php');

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $cbnames=array_keys($_POST);
    if(count($cbnames) != 0) {
       $id_numbers=array();
       foreach($cbnames as &$val) {
           // echo $val;
          $num=preg_replace( "/[^0-9]/", "", $val);
          $str = "cb" . $num;
          if (isset($_POST[$str])) {
              //echo "<br> val: " . $val . " num: " . $num;
              $mysql->approve($num);
          }
       }
       header("location: webmaster.php?select=4");
    }
?>