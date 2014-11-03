<?
$path = "/nav/executeLogin.php";
?>

<form action="<? echo $path; ?>" method="post" accept-charset="UTF-8">

    <input class="form-control" style="margin-bottom: 15px;" type="text" name="un"  
           size="50" <?
                        if(isset($_COOKIE['remember_me'])) {
                            echo "value=\"" . $_COOKIE['remember_me'] . "\"";
                        } else {
                            echo "placeholder=\"Username\"";
                        }
                    ?>
           />
    <input class="form-control" id="user_password" style="margin-bottom: 15px;" type="password" name="pw" 
           size="50" placeholder="Password"/>
    <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" 
           name="remember" value="1" 
            <?php 
                if(isset($_COOKIE['remember_me'])) {
                    echo 'checked="checked"';
                }
                else {
                    echo '';
                }
           ?>
           />
    <label class="string optional" for="user_remember_me"> Remember me</label>
 
    <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" 
           type="submit" value="Sign In" />
    <br>
</form>