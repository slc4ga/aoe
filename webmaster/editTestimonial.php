<?

require_once '../nav/mysql.php';
require_once '../nav/constants.php';

$mysql = new Mysql();
session_start();

$req = $_GET['req'];

if(!isset($_SESSION['user_id'])) {
    header("location: ../");
}

    if($_POST) {
        if($_POST['testimonialbtn']) {
            if(!empty($_POST['message'])) {
                $mysql->editTestimonial($req, $_POST['message']);
                header("location: webmaster.php?select=4&t=yes");
            } else {
                header("location: webmaster.php?select=4&t=no");
            }
        }
    }


?>

<!DOCTYPE html>
<html>

    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> A.O.E Edit Testimonial </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
            
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="../bootstrap/js/bootbox.min.js"></script>
    
        <script src="../bootstrap/js/bootstrap.js"></script>
        <script>
            $(function() {
                // Setup drop down menu
                $('.dropdown-toggle').dropdown();
     
                // Fix input element click problem
                $('.dropdown input, .dropdown label').click(function(e) {
                    e.stopPropagation();
                });
            });
            
        </script>
        
    </head>
    <body>
    
        <div class="container">
            <?
                include '../nav/navbar.php';
            ?>
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <li id="pcLi">
                            <a href="javascript.void(0);" id="pc">Add Pledge Class</a></li>
                        <li id="sistersLi" >
                            <a href="javascript.void(0);" id="sistersedit">Manage Sisters</a></li>
                        <li id="leadershipLi" >
                            <a href="javascript.void(0);" id="leadershipedit">Update Leadership</a></li>
                        <li id="testimonialsLi" >
                            <a href="javascript.void(0);" id="testimonials">Manage Testimonials</a></li>
                    </ul>
                     
                </div>
                <div class="col-md-9">   
                    <div id="content">
                        <h2>Edit Sister Testimonial</h2>
                        <p>
                        
                            Please fill out the form below to edit a testimonial.
                        
                        </p>
                        <p>
                            <em>We'd love to publish anything you have to say about A&Omega;E at UVa! Let us know why you decided to rush, what 
                                your favorite memory is, how you think being a sister has enhanced your time in Charlottesville...whatever you want! 
                                Just try to keep them specific: we all love A&Omega;E, but just saying that doesn't tell potential Candidates why they 
                                should rush!</em>
                        </p>
                        <hr>
                        <?
                            $message = $_GET['t'];
                            if(isset($message) && $message == "no") {
                                echo "<div class=\"alert alert-error\">  
                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                        <strong>Testimonial submission failed...</strong>please write a message before trying to submit!
                                    </div>";     
                            }
                        ?>
                        <form method="post" action="#">
                            <div class="row">
                                <?
                                    $id = $_GET['req'];
                                    $message = $mysql->getTestimonial($id);
                                ?>
                                <div class="col-md-12">
                                    <label for="message"><b>Testimonial: </b></label>
                                    <textarea id="message" class="form-control" name="message" style="width:100%" rows="9"><? echo $message; ?></textarea>
                                </div>
                            
                            </div>
                            <br>
                            
                            <input class="btn btn-lg btn-success" type="submit" name="testimonialbtn" 
                                   id="testimonialbtn" value="Submit Testimonial" />
                        </form>
                    </div>
                </div>
            </div>
            
            <?
                include '../nav/footer.php';
            ?>
        
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("pc").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'addPC.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("pcLi").className += " active";
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
                
                document.getElementById("testimonials").onclick = function() {
                    $('.nav-pills li').removeClass('active');
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