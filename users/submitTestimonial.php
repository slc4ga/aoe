<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


?>

<div class="col-md-12">
                     
    <h2>Approve Sister Testimonial</h2>
    <p>
    
        Please fill out the form below to add a your own testimonial.
    
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
        
            <div class="col-md-12">
                <label for="message"><b>Testimonial: </b></label>
                <textarea id="message" class="form-control" name="message" style="width:100%" rows="9"></textarea>
            </div>
        
        </div>
        <br>
        
        <input class="btn btn-lg btn-success" type="submit" name="testimonialbtn" 
               id="testimonialbtn" value="Submit Testimonial" />
    </form>
    
</div>