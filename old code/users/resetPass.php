<?php

    require_once '../nav/mysql.php';
    $mysql = new Mysql();
    session_start();

    $er = $_SESSION["resetPass"];
    unset($_SESSION["resetPass"]);

    // should only be accessible by logged in user later - add restrictions here

?>

        <div class="col-md-11">
            <div class="modal-header">
                <h3>Password Reset</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <form class="form-horizontal" action="resetAction.php" method="POST">
                                <fieldset>
                                    <div id="legend">
                                        <legend class="">Enter Account Info</legend>
                                    </div>    
                                    <? if($er == 'oldempty') { echo "<div class=\"alert alert-error\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Oh no!!</strong>  You forgot to enter an old password.  
                                                        </div>"; 
                                                       }
                                         if($er == 'old') { echo "<div class=\"alert alert-danger\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Uh oh!</strong>  Looks like your old password is incorrect.  
                                                        </div>"; 
                                                    }
                                         if($er == 'newempty') { echo "<div class=\"alert alert-danger\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Oh no!!</strong>  You forgot to enter a new password.  
                                                        </div>"; 
                                                    }
                                         if($er == 'newmatch') { echo "<div class=\"alert alert-danger\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Hmmm...</strong>  Looks like those new passwords don't match. Try again! 
                                                        </div>"; 
                                                    }
                                         if($er == 'success') { echo "<div class=\"alert alert-success\">  
                                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                                        <strong>Success!</strong>  Password reset.  
                                                        </div>"; 
                                                    }
                                    ?>
                                    <!-- Old Password -->
                                        <input type="password" style="width: 40%" class="form-control" id="password" name="pass1" 
                                               placeholder="Old Password" class="input-xlarge"/> 
                                    <br>
                                    <!-- New  Password1 -->
                                        <input type="password" style="width: 40%" class="form-control" id="password" name="pass2" 
                                               placeholder="New Password" class="input-xlarge"/> 
                                    <br>
                                    <!-- New Password2 -->
                                        <input type="password" style="width: 40%" class="form-control" id="password" name="pass3" 
                                               placeholder="Confirm New Password" class="input-xlarge"/> 
                                    <hr>
                                    <!-- Button -->
                                        <input type="submit" class="btn btn-lg btn-success">
                                </fieldset>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>


        