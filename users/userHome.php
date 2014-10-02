<?
    require_once '../nav/mysql.php';
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $mysql = new Mysql();

    if($_POST) {
        if($_POST['testimonialbtn']) {
            if(!empty($_POST['message'])) {
                $mysql->addTestimonial($_POST['message']);
                header("location: userHome.php?select=1&t=yes");
            } else {
                header("location: userHome.php?select=3&t=no");
            }
        }
    }

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <title> A.O.E Pi Account </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
        
    </head>
    <body>
    
        <div class="container"> 
            <?
                include '../nav/navbar.php';
            ?>
            <div class="col-md-12">
                <?
                    echo "<h1>Welcome " . $mysql->getFullName($_SESSION['user_id']) . "!</h1><hr>";
                ?>
            </div>

            <div class="row">            
                <div class="col-md-3">
     
                    <ul class="nav nav-pills nav-stacked">
                        <li id="profileLi" class="active">
                            <a href="javascript.void(0);" id="profile">View Profile</a></li>
                        <li id="editLi" >
                            <a href="javascript.void(0);" id="edit">Edit Profile</a></li>
                        <li id="testimonialLi" >
                            <a href="javascript.void(0);" id="testimonial">Submit Testimonial</a></li>
                        <?
                            if($mysql->checkWebmaster($_SESSION['user_id'])) {
                                echo "<li>
                                    <a href='../webmaster/webmaster.php' id='webmaster'>Webmaster Capabilities</a></li>";
                            }
                        ?>
                    </ul>
                     
                 </div>
                
                <div class="col-md-9">
                    <div>
                        <?
                            $message = $_GET['t'];
                            if(isset($message) && $message == "yes") {
                                echo "<div class=\"alert alert-success\">  
                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                        <strong>Testimonial submission succeeded!</strong>
                                    </div>";     
                            }
                        ?>
                    </div>
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav li').removeClass('active');
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'profile.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("profileLi").className += " active";
                            } else if(select.indexOf(2) != -1) {
                                $.ajax({
                                    url: 'editProfile.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("editLi").className += " active";
                            } else if(select.indexOf(3) != -1) {
                                $.ajax({
                                    url: 'submitTestimonial.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("testimonialLi").className += " active";
                            }
                        </script>
                    </div>
                </div>
            </div>
            <?
                include '../nav/footer.php';
            ?>
        </div>
         <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("profile").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'profile.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("profileLi").className += " active";
                    return false;
                }
                
                document.getElementById("edit").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'editProfile.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("editLi").className += " active";
                    return false;
                }
                
                document.getElementById("testimonial").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'submitTestimonial.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("testimonialLi").className += " active";
                    return false;
                }
                
            }
        </script>
    </body>

</html>