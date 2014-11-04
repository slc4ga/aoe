<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


?>

<div class="col-md-12">
                     
    <h2>Submit Anonymous Feedback</h2>
    <p>
    
        Please fill out the form below to submit <em>anonymous</em> feedback to exec. Remember to be constructive!
    
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
        
            <div class="col-md-12">
                <label for="message"><b>Feedback: </b></label>
                <textarea id="message" class="form-control" name="message" style="width:100%" rows="9"></textarea>
            </div>
        
        </div>
        <br>
        
        <input class="btn btn-lg btn-success" type="submit" name="feedbackbtn" 
               id="feedbackbtn" value="Submit Feedback" />
    </form>
    
</div>