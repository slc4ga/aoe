<?
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Alpha Omega Epslion at UVa</title>
        
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="bootstrap/css/carosel.css" type="text/css">
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        
    </head>
    
    <body>
    
        <div class="container">
            
            <? include 'nav/navbar.php'; ?>
            
            <div class="jumbotron" style="padding: 0px">
                <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="/img/static/Cover3.jpg" alt="Homecomings">
          <div class="container">
            <div class="carousel-caption">
              <h1 style="text-transform:none;">a&Omega;e loves our sisters!</h1>
              <p>We rep that orange and blue every day, but especially on Homecomings with our alumnae!</p>
              <p><a class="btn btn-primary" href="/sisters/sisters.php?select=4" role="button">View the Sisters</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="/img/static/Cover2.jpg" alt="Foxfield">
          <div class="container">
            <div class="carousel-caption">
              <h1>Foxfield</h1>
              <p>We may be UVa's only engineering sorority, but we still enjoy the Races!</p>
              <p><a class="btn btn-primary" href="/public/photos.php" role="button">More Pictures</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="/img/static/Cover1.jpg" alt="Recruitment">
          <div class="container">
            <div class="carousel-caption">
              <h1>Looking to pledge?</h1>
              <p>A&Omega;E holds recruitment events in the Spring, and all the information will be posted on our recruitment page.</p>
              <p><a class="btn btn-primary" href="/public/recruitment.php" role="button">Recruitment Info</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
                
            </div>
            
            <div class="row">
                
                 <? include 'nav/sidemenu.php'; ?>
                
                 <div class="col-md-8">
                     
                     <h2>Alpha Omega Epsilon - Pi Chapter</h2>
                     
                     <p>Welcome to the Pi Chapter of Alpha Omega Epsilon at the University of Virginia! Please take a look around, 
                         and if you have any questions, please feel free to <a href="contact.php">contact us</a>.
                     </p>
                     
                     <p>
                         Alpha Omega Epsilon is a professional and social sorority composed of female engineering and techincal 
                         science students and alumnae. Founded on November 13, 1983 at Marquette University, the sorority promotes 
                         ideals and objectives that further the advancement of female engineers and technical scientists. At the 
                         same time, the sisters of Alpha Omega Epsilon develop bonds of lifelong friendships and strive for 
                         scholarship and academic achievement. 
                     </p>
                     
                     <p>
                         The Pi Chapter of A&Omega;E attends local Charlottesville events, such as football games and Foxfield, 
                         works with local Girl Scouts on science and technology badges, and raises money for local charities while 
                         encouraging its members to get involved in the UVa Engineering school and the greater University 
                         community.
                     </p>
                         
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
                    <br> 
                    <h4>Disclaimer: Non-affiliation</h4>
                    <p>
                        Although this organization has members who are University of Virginia students and may have 
                        University employees associated or engaged in its activities and affairs, the organization is not a 
                        part of or an agency of the University. It is a separate and independent organization which is 
                        responsible for and manages its own activities and affairs. The University does not direct, 
                        supervise or control the organization and is not responsible for the organization’s contracts, acts 
                        or omissions.
                    </p>
                    <hr>
                    <h4>Source Code</h4>
                    <p>
                        The source code for this site can be found at <a href="https://github.com/slc4ga/aoe">this github repo</a>, 
                        and was all written by <a href="mailto:slc4ga@virginia.edu">Steph Colen</a>.
                    </p>
                    <br>
                 </div>
                
            </div>
            
            <? include 'nav/footer.php'; ?>
        </div>
    
    </body>

</html>