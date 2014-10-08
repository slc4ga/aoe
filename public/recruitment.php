<?
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A.O.E Pi - Recruitment</title>
        
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/carosel.css" type="text/css">
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
    </head>
    
    <body>
    
        <div class="container">
            
            <? include '../nav/navbar.php'; ?>
            
            <div class="jumbotron" style="padding: 0px">
                <!-- Carousel
                ================================================== -->
                <div id="myCarousel" class="carousel slide" style="height: 600px">
                    <div class="carousel-inner">
                        <div class="item active" style="height: 600px">
                            <img src="../img/static/Recruitment2014.jpg" alt="Recruitment 2014 - Nu Class" style="height: 600px">
                            <div class="container">
                                <div class="carousel-caption" style="margin-top: 225px">
                                    <h1>new babies!</h1>
                                    <p class="lead">
                                        We'll be holding recruitment events again in January 2015, but in the mean time get to know our current babies: the Nu Class!
                                    </p>
                                    <p><a class="btn btn-primary" href="/sisters/sisters.php?select=5" role="button">Nu Class</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.carousel -->
                
            </div>
            
            <div class="row">
                
                 <? include '../nav/sidemenu.php'; ?>
                
                 <div class="col-md-8">

                         
                    <h2>Recruitment 2015</h2>
                     
                      <p>
                        We currently have 97 active sisters. Unfortunately, Recruitment for the Nu class just finished, but we will be recruiting again in January of 2015. 
                    <p>
                        In order to be eligible for A&Omega;E Recruitment, you must meet the following requirements:
                    </p>
                    
                    <ol>
                        <li>You are enrolled in the Engineering School </li>
                        <li>You are a current first or second year</li>
                        <li>You are able to attend most of our Recruitment events</li>
                    </ol>
                     
                    <p>
                        More information about recruitment will be posted as it becomes available, so please continue to check our 
                        website. If you have any questions feel free to <a href="contact.php">contact our exec board</a>.
                    </p>
                 </div>
                
            </div>
            <? include '../nav/footer.php'; ?>
        </div>
    
    </body>

</html>