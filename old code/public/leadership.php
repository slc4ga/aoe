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
        <title> A.O.E. Pi - Leadership </title>
            
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
                        <li id="execLi" class="active">
                            <a href="javascript.void(0);" id="exec">Exec Board</a></li>
                        <li id="chairsLi" >
                            <a href="javascript.void(0);" id="chairs">Chairs</a></li>
                    </ul>
                     
                 </div>
                
                <div class="col-md-9">
                    <div id="content">
                        <script type="text/javascript">
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav-pills li').removeClass('active');
                            if(select == 2) {
                                $.ajax({
                                    url: 'getLeadership.php',
                                    data: { class: 'chairs' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("chairsLi").className += " active";
                            } else {
                                $.ajax({
                                    url: 'getLeadership.php',
                                    data: { class: 'exec' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("execLi").className += " active";
                            } 
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("exec").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'getLeadership.php',
                        data: { class: 'exec' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("execLi").className += " active";
                    return false;
                }
                
                document.getElementById("chairs").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'getLeadership.php',
                        data: { class: 'chairs' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("chairsLi").className += " active";
                    return false;
                }
                
            }
        </script>
    </body>
</html>