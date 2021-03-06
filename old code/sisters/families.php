<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();
?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
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
                        <li id="kappaLi" class="active">
                            <a href="javascript.void(0);" id="kappa">Kappa Class</a></li>
                        <li id="lambdaLi" >
                            <a href="javascript.void(0);" id="lambda">Lambda Class</a></li>
                        <li id="muLi" >
                            <a href="javascript.void(0);" id="mu">Mu Class</a></li>
                        <li id="alumLi" >
                            <a href="javascript.void(0);" id="alum">Alumnae</a></li>
                    </ul>
                     
                 </div>
                <?
                    $result = $mysql->getFamilies();
                    //$result = $mysql->getClassMembers($class);
                    if (gettype($result) == "boolean") {
                        echo "failed<br>";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            echo "li";
                                    echo '<li id="';
                            echo $row[0] + 'Li" class="active">
                                        <a href="javascript.void(0);" id="' + $row[0] + '">' + $row[0] + 'Family</a></li>';
                            echo "li2";
                        }
                    }
                ?>
                <div class="col-md-8">
                    <div id="content">
                        <script type="text/javascript">
                            /*var select = window.location.href.toString().split("=")[1];
                            $('.nav li').removeClass('active');
                            if(select == 2) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'lambda' },
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("lambdaLi").className += " active";
                            } else if(select == 3) {
                                $.ajax({
                                    url: 'pledgeclass.php',
                                    data: { class: 'mu' },
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
                            } else {
                                if(isNumber(select)) {
                                    $.ajax({
                                        url: 'pledgeclass.php',
                                        data: { class: 'kappa' }, 
                                        success: function(data){
                                            $('#content').html(data);   
                                        }
                                    });
                                    document.getElementById("kappaLi").className += " active";
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
                            }*/
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("kappa").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'kappa' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("kappaLi").className += " active";
                    return false;
                }
                
                document.getElementById("lambda").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'lambda' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("lambdaLi").className += " active";
                    return false;
                }
                
                document.getElementById("mu").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'pledgeclass.php',
                        data: { class: 'mu' },
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("muLi").className += " active";
                    return false;
                }
                
                document.getElementById("alum").onclick = function() {
                    $('.nav li').removeClass('active');
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
                
            }
        </script>
    </body>
</html>