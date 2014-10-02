<?php
    $er=$_GET['er'];
    if($er == 'username') {
        $er = "That username does not exist.";
    }
    if($er == 'password') {
        $er = "That username and password do not match.";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Login - A.O.E Pi  </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="modal-header">
                <h3>Have an Account?</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <form class="form-horizontal" action="executeLogin.php" method="POST">
                                <fieldset>
                                    <div id="legend">
                                        <legend class="">Login</legend>
                                    </div>    
                                    <? if(!empty($er)) { 
                                echo "<div class=\"alert alert-danger\">  
                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                        <strong>Uh-oh! Looks like something went wrong...</strong>$er
                                    </div>"; 
                                           }
                                    ?>
                                    <!-- Username -->
                                        <input type="text" class="form-control" style="width: 20%" id="username" name="un" 
                                               placeholder="Username" 
                                               <?
                                                    if(isset($_COOKIE['remember_me'])) {
                                                        echo "value=\"" . $_COOKIE['remember_me'] . "\"";
                                                    } else {
                                                        echo "placeholder=\"Username\"";
                                                    }
                                                ?>
                                               /> 
                                    <br><br>
                                    <!-- Password-->
                                        <input type="password" class="form-control" style="width: 20%" id="password" name="pw" 
                                                placeholder="Password" >
                                    <br><br>
                                    <!-- Remember me -->
                                    <div class="checkbox">
                                        <input type="checkbox" name="remember" value="1" 
                                                           <?php
                                                                if(isset($_COOKIE['remember_me'])) {
                                                                    echo 'checked="checked"';
                                                                }
                                                                else {
                                                                    echo '';
                                                                }
                                                            ?>
                                               /> Remember Me
                                        </div>
                                    <hr>
                                    <!-- Button -->
                                        <button class="btn btn-success btn-lg">Login</button>
                                </fieldset>
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


        