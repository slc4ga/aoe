<?
    include_once '../nav/mysql.php';
    
    $mysql = New Mysql();
    session_start();

    if($_POST) {
        if(!empty($_POST['name']) && !empty($_POST['reply']) && !empty($_POST['category']) && !empty($_POST['message'])) {
            $mysql->sendMessage($_POST['name'], $_POST['reply'], $_POST['category'], $_POST['message']);
        }
        else {
            header("location:contact.php?er=details");
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A.O.E Pi - Contact</title>
        
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
    </head>
    
    <body>
    
        <div class="container">
            
            <? include '../nav/navbar.php'; ?>
            
            <div class="row">
                
                <? include '../nav/sidemenu.php'; ?>
                
                 <div class="col-md-8">
                     
                     <h2>Contact Exec</h2>
                     <p>
                     
                        Please fill out the form below to contact the A&Omega;E Pi Chapter Exec Board. All fields are required.
                     
                     </p>
                     <?
                        $er = $_GET['er'];
                        if($er == 'details') {
                            echo "<div class=\"alert alert-danger\">  
                                    <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                    <strong>Uh-oh!</strong> Some details are missing. Try filling out the form again.
                                </div>";      
                        }
                     ?>
                     <hr>
                     <form name="myForm" method="post" action="#">
                        <div class="row">
                            
                            <div class="col-md-5">
                                <label for="name">Name: </label>
			                    <input type="text" class="form-control" name="name" />
                            </div>
                        </div>
                         <br>
                         <div class="row">
                            <div class="col-md-5">
                                <label for="reply">Reply-To: </label>
			                    <input type="email" class="form-control" name="reply" placeholder="email@example.com"/>
                            </div>
                        </div>
                         <br>
                        <div class="row">
                            <div class="col-md-5">
                                
                                <label for="category">Category: </label>
                                <select name="category" class="form-control" >
                                    <option value="Recruitment">Recruitment</option>
                                    <option value="Corporate Recruiting">Corporate Recruiting</option>
                                    <option value="Alumnae">Alumnae Questions</option>
                                    <option value="Attendance">Sister Attendance</option>
                                </select>
                                
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                        
                            <div class="col-md-12">
                                <label for="message">Message Content: </label>
                                <textarea id="message" class="form-control" name="message" 
                                          placeholder="Type message here." style="width:100%" rows="6"></textarea>
                            </div>
                        
                        </div>
                        <br>
                        <button class="btn btn-lg btn-success" type="submit"> Send Message </button>   
                     </form>
                     
                 </div>
                
            </div>
            <div class="footer">
                <?
                    include '../nav/footer.php';
                ?>
            </div> 
            
        </div>
    
    </body>

</html>