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
        <title> A.O.E. Pi - Sisters </title>
            
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
                        <li id="lambdaLi" >
                            <a href="javascript.void(0);" id="lambda">Lambda Class</a></li>
                        <li id="muLi" >
                            <a href="javascript.void(0);" id="mu">Mu Class</a></li>
                        <li id="nuLi" >
                            <a href="javascript.void(0);" id="nu">Nu Class</a></li>
                        <li id="alumLi" >
                            <a href="javascript.void(0);" id="alum">Alumnae</a></li>
                    </ul>
                     
                 </div>
                
                <div class="col-md-8">
                    <div id="content">
                        <script type="text/javascript">
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav-pills li').removeClass('active');
                            if(typeof select === 'undefined' || select == 2) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'Lambda' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("lambdaLi").className += " active";
                            } else if(select == 3) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'Mu' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("muLi").className += " active";
                            } else if(select == 4) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'Alumnae' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("alumLi").className += " active";
                            } else if(select == 5) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'Nu' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("nuLi").className += " active";
                            } else {
                                    $.ajax({
                                        url: 'sisProf.php',
                                        data: { id: select }, 
                                        success: function(data){
                                            $('#content').html(data); 
                                            updatePC(select);
                                        }
                                    });
                            }
                            function isNumber(n) {
                                return !isNaN(parseFloat(n)) && isFinite(n);
                            }
                            function updatePC(id) {
                                $.ajax({
                                    url: 'getPC.php',
                                    data: { select: select }, 
                                    success: function(data){
                                        document.getElementById(data).className += " active";
                                    }
                                });        
                            }
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("lambda").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'Lambda' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("lambdaLi").className += " active";
                    return false;
                }
                
                document.getElementById("mu").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'Mu' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("muLi").className += " active";
                    return false;
                }
                
                document.getElementById("alum").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'Alumnae' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("alumLi").className += " active";
                    return false;
                }

                document.getElementById("nu").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'Nu' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("nuLi").className += " active";
                    return false;
                }
                
            }
        </script>
    </body>
</html>