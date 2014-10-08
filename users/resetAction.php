<?  

   include '../nav/mysql.php';
   $mysql = New Mysql();
   session_start();

   if($_POST) {
       if(!empty($_POST['pass1'])) {
           if(!empty($_POST['pass2']) && !empty($_POST['pass3'])) {
               if($_POST['pass2'] == $_POST['pass3']) {
                    unset($_SESSION["resetPass"]);
                   $er = $mysql->resetPass($_POST['pass1'], $_POST['pass2']);
                   //echo $er;
                   //echo "session: " . $_SESSION["resetPass"];
               } else {
                   $_SESSION["resetPass"] = "newmatch";
               }
           } else {
               $_SESSION["resetPass"] = "newempty";
           }
       } else {
           $_SESSION["resetPass"] = "oldempty";
       }
       header("location: userHome.php?select=4");
    }

?>