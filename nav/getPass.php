<?php

    require_once 'mysql.php';
    $mysql = new Mysql();

    $er=$_GET['er'];
    if($er == 'login') {
        $er = "That username does not exist.";
    }

    if($_POST) {
       if(!empty($_POST['un'])) {
           $er = $mysql->getPass($_POST['un']);
           if(strlen($er) != 0) {
               header("location: getPass.php?er=login");
           } else {
               header("location: passSuccess.php");
           }
       }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Retrieve AOE Pi Password </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="modal-header">
                <h3>Password Retrieval</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <form class="form-horizontal" action="#" method="POST">
                                <fieldset>
                                    <div id="legend">
                                        <legend class="">Find Account Info</legend>
                                    </div>    
                                    <? if(!empty($er)) { echo "<div class=\"alert alert-error\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Error!</strong>  $er  
                                                        </div>"; 
                                                       }
                                    ?>
                                    <!-- Username -->
                                        <input type="text" class="form-control" style="width: 20%" id="username" name="un" 
                                               placeholder="Username" class="input-xlarge"
                                               <?
                                                    if(isset($_COOKIE['remember_me'])) {
                                                        echo "value=\"" . $_COOKIE['remember_me'] . "\"";
                                                    } else {
                                                        echo "placeholder=\"Username\"";
                                                    }
                                                ?>
                                               /> 
                                    <hr>
                                    <!-- Button -->
                                        <button class="btn btn-success">Submit</button>
                                </fieldset>
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


        