<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();
?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
        <title> A.O.E. Pi - About </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
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
                        <li id="aoeLi" class="active">
                            <a href="javascript.void(0);" id="aoe">A&Omega;E History</a></li>
                        <li id="piLi" >
                            <a href="javascript.void(0);" id="pi">Pi History</a></li>
                        <li id="missionLi" >
                            <a href="javascript.void(0);" id="mission">Mission Statement</a></li>
                        <li id="idealsLi" >
                            <a href="javascript.void(0);" id="ideals">Ideals and Objectives</a></li>
                        <li id="testimonialsLi" >
                            <a href="javascript.void(0);" id="testimonials">Testimonials</a></li>
                    </ul>
                     
                 </div>
                
                <div class="col-md-8">
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav-pills li').removeClass('active');
                            if(select == 2) {
                                $.ajax({
                                    url: 'pihist.php', 
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("piLi").className += " active";
                            } else if(select == 3) {
                                $.ajax({
                                    url: 'mission.php', 
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("missionLi").className += " active";
                            } else if(select == 4) {
                                $.ajax({
                                    url: 'ideals.php', 
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("idealsLi").className += " active";
                            } else if(select == 5) {
                                $.ajax({
                                    url: 'testimonials.php', 
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("testimonialsLi").className += " active";
                            } else {
                                $.ajax({
                                    url: 'aoehist.php', 
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("aoeLi").className += " active";
                            } 
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("aoe").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'aoehist.php', 
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("aoeLi").className += " active";
                    return false;
                }
                
                document.getElementById("pi").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pihist.php', 
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("piLi").className += " active";
                    return false;
                }
                
                document.getElementById("mission").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'mission.php', 
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("missionLi").className += " active";
                    return false;
                }
                
                document.getElementById("ideals").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'ideals.php', 
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("idealsLi").className += " active";
                    return false;
                }
                
                document.getElementById("testimonials").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'testimonials.php', 
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