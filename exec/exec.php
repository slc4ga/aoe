<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();
    date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    if($_POST) {
        if(!empty($_POST['letter']) && !empty($_POST['info'])) {
            $mysql->addPledgeClass($_POST['letter'], $_POST['info']);
            header("location:webmaster.php?select=2");
        }
    }

    $add = $_GET['add'];
    echo "<script>
            var add = '$add';
            </script>";

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> A.O.E. Pi - Exec </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
            
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script src="../bootstrap/js/bootbox.min.js"></script>

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
                        <li id="pointsLi" class="active">
                            <a href="javascript.void(0);" id="points">Manage Points</a></li>
                        <li id="sistersLi" >
                            <a href="javascript.void(0);" id="sistersedit">Manage Sisters</a></li>
                        <li id="leadershipLi" >
                            <a href="javascript.void(0);" id="leadershipedit">Update Leadership</a></li>
                    </ul>
                 </div>
                
                <div class="col-md-9">
                    <div id="content">
                    
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("select")[1];
                            $('.nav-pills li').removeClass('active');
                            if(typeof select === 'undefined') {} else {
                                select = select.substring(1);
                            }
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'points.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("pointsLi").className += " active";
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
                            }
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
                            
            function deleteEvent(id, divId) {
                $.ajax({
                        url: "deleteEvent.php",
                        data: { id: id,
                                divId: divId },
                        success: function(data){  
                            $('#' + divId).html(data);
                        }
                    });
                    return false;
            }
            
            function addChapter() {
                var date = $("#chapterDate").val();
                $.ajax({
                        url: "addChapter.php",
                        data: { date: date},
                        success: function(data){  
                            $('#9').html(data);
                        }
                    });
                    return false;
            }
            
            window.onload = function() {
                
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
                
                document.getElementById("sistersedit").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'editSisters.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("sistersLi").className += " active";
                    return false;
                }
                
                document.getElementById("leadershipedit").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'editLeadership.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("leadershipLi").className += " active";
                    return false;
                }
            }
        </script>
    </body>
</html>