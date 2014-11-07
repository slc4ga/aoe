<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();
    date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    if($_POST) {
        if(!empty($_POST['letter']) && !empty($_POST['info'])) {
            $mysql->addPledgeClass($_POST['letter'], $_POST['info']);
            header("location:webmaster.php?select=2");
        }
    }

    $add = $_GET['add'];
    $exempt = $_GET['exempt'];
    $approve = $_GET['approve'];
    $pos = $_GET['pos'];
    echo "<script>
            var add = '$add';
            </script>";
    echo "<script>
            var exempt = '$exempt';
            </script>";
    echo "<script>
            var approve = '$approve';
            </script>";
    echo "<script>
            var pos = '$pos';
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
                            <a href="javascript.void(0);" id="points">Manage Events</a></li>
                        <li id="summaryLi" >
                            <a href="javascript.void(0);" id="summary">Points Summary</a></li>
                        <li id="attendanceLi" >
                            <a href="javascript.void(0);" id="attendance">Approve Attendance</a></li>
                        <li id="sistersLi" >
                            <a href="javascript.void(0);" id="sistersedit">Manage Sisters</a></li>
                        <li id="leadershipLi" >
                            <a href="javascript.void(0);" id="leadershipedit">Update Leadership</a></li>
                        <li id="feedbackLi" >
                            <a href="javascript.void(0);" id="feedback">View Feedback</a></li>
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
                            } else if(select.indexOf(4) != -1) {
                                $.ajax({
                                    url: 'pointsSummary.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("summaryLi").className += " active";
                            } else if(select.indexOf(5) != -1) {
                                $.ajax({
                                    url: 'attendanceList.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("attendanceLi").className += " active";
                            } else if(select.indexOf(6) != -1) {
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
            
            function approveEvent(id, divId) {
                 bootbox.prompt("How many points does this event get?", function(result) {                
                    if (result === null) {                                             
                        // do nothing                             
                    } else {
                        $.ajax({
                            url: "approveBabyEvent.php",
                            data: { id: id,
                                    points: result, 
                                    divId: divId },
                            success: function(data){  
                                $('#' + divId).html(data);
                            }
                        });                    
                    }
                });
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
            
            function summary() {
                var val = $("#month").val();
                $.ajax({
                    url: "getPointsSummary.php",
                    data: { date: val,
                            calc: false },
                    success: function(data){  
                        $('#summaryInfo').html(data);
                    }
                });
                return false; 
            }
            
            function semesterEvents() {
                var val = $("#semester").val();
                $.ajax({
                    url: "getSemesterEvents.php",
                    data: { date: val },
                    success: function(data){  
                        $('#semesterEvents').html(data);
                    }
                });
                return false; 
            }
            
            function semesterBonus(date) {
                alert(date);
                $.ajax({
                    url: "getSemesterEvents.php",
                    data: { date: date,
                            calc: true },
                    success: function(data){  
                        $('#semesterEvents').html(data);
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
                
                document.getElementById("summary").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pointsSummary.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("summaryLi").className += " active";
                    return false;
                }
                
                document.getElementById("attendance").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'attendanceList.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("attendanceLi").className += " active";
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