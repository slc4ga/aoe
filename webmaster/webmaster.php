<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    if($_POST) {
        if(!empty($_POST['letter']) && !empty($_POST['info'])) {
            $mysql->addPledgeClass($_POST['letter'], $_POST['info']);
            header("location:webmaster.php?select=2");
        }
    }

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <title> A.O.E. Pi - Webmaster </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
            
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="../bootstrap/js/bootbox.min.js"></script>
    

        <!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->
        <script src="../bootstrap/js/bootstrap.js"></script>
            
        
    </head>
    <body>
    
        <div class="container">
            <?
                include '../nav/navbar.php';
            ?>
            
            <div class="row">            
                <div class="col-md-3">
     
                    <ul class="nav nav-pills nav-stacked">
                        <li id="pcLi" class="active">
                            <a href="javascript.void(0);" id="pc">Add Pledge Class</a></li>
                        <li id="sistersLi" >
                            <a href="javascript.void(0);" id="sisters">Manage Sisters</a></li>
                        <li id="leadershipLi" >
                            <a href="javascript.void(0);" id="leadership">Update Leadership</a></li>
                        <li id="testimonialsLi" >
                            <a href="javascript.void(0);" id="testimonials">Manage Testimonials</a></li>
                    </ul>
                     
                 </div>
                
                <div class="col-md-9">
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav li').removeClass('active');
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'addPC.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("pcLi").className += " active";
                            } else if(select.indexOf(2) != -1) {
                                $.ajax({
                                    url: 'editSisters.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("sistersLi").className += " active";
                            } else if(select.indexOf(3) != -1) {
                                $.ajax({
                                    url: 'editLeadership.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("leadershipLi").className += " active";
                            } else if(select.indexOf(4) != -1){
                                $.ajax({
                                    url: 'addTestimonials.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("testimonialsLi").className += " active";
                            }
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("pc").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'addPC.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("pcLi").className += " active";
                    return false;
                }
                
                document.getElementById("sisters").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'editSisters.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("sistersLi").className += " active";
                    return false;
                }
                
                document.getElementById("leadership").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'editLeadership.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("leadershipLi").className += " active";
                    return false;
                }
                
                document.getElementById("testimonials").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'addTestimonials.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("testimonialsLi").className += " active";
                    return false;
                }
            }
        </script>
    </body>
</html>