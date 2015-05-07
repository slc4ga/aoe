<?
    include_once '../nav/mysql.php';
    session_start();

    $mysql = New Mysql();
    
    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }
?>

<div class="col-md-11">
                     
    <h2>Add Pledge Class</h2>
    <p>
    
        Please fill out the form below to add sisters to a new pledge class.
    
    </p>
    <hr>
    <form name="myForm" method="post" action="#">
        <div class="row">
            
            <div class="col-md-4">
                <label for="letter"><b>Pledge Class: </b></label>
                <input type="text" class="form-control" placeholder="Nu" name="letter" />
            </div>
        </div>
        <br>
        <div class="row">
        
            <div class="col-md-12">
                <label for="info"><b>Candidate Information: </b></label>
                <p> 
                    Enter data in the following format, one candidate per line:<br>
                    <em>Computing ID,First Name,Last Name</em>
                </p>
                <textarea id="info" class="form-control" name="info" style="width:100%" rows="6"></textarea>
            </div>
        
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-lg btn-success" type="submit"> Add Class </button>
            </div>
        </div>
    </form>
    
    </div>