<?
    require_once '../nav/mysql.php';
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $mysql = new Mysql();
    date_default_timezone_set('America/New_York');

    if($_POST) {
        if($_POST['testimonialbtn']) {
            if(!empty($_POST['message'])) {
                $mysql->addTestimonial($_POST['message']);
                header("location: userHome.php?select=1&t=yes");
            } else {
                header("location: userHome.php?select=3&t=no");
            }
        } else if($_POST['feedbackbtn']) {
            if(!empty($_POST['message'])) {
                $mysql->addFeedback($_POST['message']);
                header("location: userHome.php?select=1&f=yes");
            } else {
                header("location: userHome.php?select=3&f=no");
            }
        }
    }

    $add = $_GET['event'];
    echo "<script>
            var add = '$add';
            </script>";

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> A.O.E Pi Account </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        <script src="../bootstrap/js/bootbox.js"></script>
        
    </head>
    <body>
    
        <div class="container"> 
            <?
                include '../nav/navbar.php';
            ?>
            <div class="col-md-12">
                <?
                    $str = $mysql->getFullName($_SESSION['user_id']);
                    $array = explode(" ", $str);
                    echo "<h1>Welcome " . $array[0] . "!</h1><hr>";
                ?>
            </div>

            <div class="row">            
                <div class="col-md-3">
     
                    <ul class="nav nav-pills nav-stacked">
                        <li id="profileLi" class="active">
                            <a href="javascript.void(0);" id="profile">View Profile</a></li>
                        <li id="calendarLi" >
                            <a href="javascript.void(0);" id="calendar">Calendar</a></li>
                        <li id="pointsLi" >
                            <a href="javascript.void(0);" id="points">Points</a></li>
                        <li id="editLi" >
                            <a href="javascript.void(0);" id="edit">Edit Profile</a></li>
                        <li id="testimonialLi" >
                            <a href="javascript.void(0);" id="testimonial">Submit Testimonial</a></li>
                        <li id="passwordLi" >
                            <a href="javascript.void(0);" id="password">Change Password</a></li>
                        <li id="feedbackLi" >
                            <a href="javascript.void(0);" id="feedback">Submit Feedback</a></li>
                        <?
                            if($mysql->checkWebmaster($_SESSION['user_id'])) {
                                echo "<li>
                                    <a href='../webmaster/webmaster.php' id='webmaster'>Webmaster Capabilities</a></li>";
                            }

                            if($mysql->checkExec($_SESSION['user_id']) == 1 ) {
                                echo "<li>
                                    <a href='../exec/exec.php' id='exec'>Exec Capabilities</a></li>";
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

                            $message = $_GET['f'];
                            if(isset($message) && $message == "yes") {
                                echo "<div class=\"alert alert-success\">  
                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                        <strong>Feedback submission succeeded!</strong>
                                    </div>";     
                            }
                        ?>
                    </div>
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav-pills li').removeClass('active');
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
                            } else if(select.indexOf(4) != -1) {
                                $.ajax({
                                    url: 'resetPass.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("passwordLi").className += " active";
                            } else if(select.indexOf(5) != -1) {
                                $.ajax({
                                    url: 'calendar.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("calendarLi").className += " active";
                            } else if(select.indexOf(6) != -1) {
                                $.ajax({
                                    url: 'points.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("pointsLi").className += " active";
                            } else if(select.indexOf(7) != -1) {
                                $.ajax({
                                    url: 'feedback.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("feedbackLi").className += " active";
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
                         
            function submitAttendance(id, divId) {
                $.ajax({
                        url: "submitAttendance.php",
                        data: { eventId: id, 
                                catId : divId },
                        success: function(data){  
                            $('#' + divId).html(data);
                        }
                    });
                return false;
            }
             
            function ontimeChapter(username, date) {
                bootbox.prompt("What is the password for this chapter?", function(result) {                
                    if (result === null) {                                             
                        // do nothing                             
                    } else {
                        $.ajax({
                            url: "chapterLogin.php",
                            data: { username : username,
                                    date : date,
                                    password : result,
                                    ontime : 1 },
                            success: function(data){  
                                $('#chapterLoginMessage').html(data);
                                $('#chapterLoginButton').html("");
                                $.ajax({
                                    url: "monthlyPoints.php",
                                    success: function(data){  
                                        $('#monthly-points').html(data);
                                    }
                                }); 
                                $.ajax({
                                    url: "categoryPoints.php",
                                    success: function(data){  
                                        $('#9-points').html(data);
                                    }
                                });
                            }
                         });                     
                    }
                });
            }
             
            function lateChapter(username, date) {
                bootbox.prompt("What is the password for this chapter?", function(result) {                
                    if (result === null) {                                             
                        // do nothing                            
                    } else {
                        $.ajax({
                            url: "chapterLogin.php",
                            data: { username : username,
                                    date : date,
                                    password : result,
                                    ontime : 0 },
                            success: function(data){  
                                $('#chapterLoginMessage').html(data);
                                $('#chapterLoginButton').html("");
                                $.ajax({
                                    url: "monthlyPoints.php",
                                    success: function(data){  
                                        $('#monthly-points').html(data);
                                    }
                                }); 
                                $.ajax({
                                    url: "categoryPoints.php",
                                    success: function(data){  
                                        $('#9-points').html(data);
                                    }
                                });
                            }
                         });                     
                    }
                });
            }
             
            window.onload = function() {
                
                document.getElementById("profile").onclick = function() {
                    $('.nav-pills li').removeClass('active');
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
                    $('.nav-pills li').removeClass('active');
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
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'submitTestimonial.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("testimonialLi").className += " active";
                    return false;
                }

                document.getElementById("password").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'resetPass.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("passwordLi").className += " active";
                    return false;
                }
                
                document.getElementById("calendar").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'calendar.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("calendarLi").className += " active";
                    return false;
                }
                
                document.getElementById("points").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'points.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("pointsLi").className += " active";
                    return false;
                }

                document.getElementById("feedback").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'feedback.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("feedbackLi").className += " active";
                    return false;
                }
            }
        </script>
    </body>

</html>