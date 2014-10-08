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
        <title>A.O.E Pi - Photos</title>
        
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link href="../bootstrap/lightbox/css/lightbox.css" rel="stylesheet" />
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
        <script src="../bootstrap/lightbox/js/jquery-1.10.2.min.js"></script>
        <script src="../bootstrap/lightbox/js/lightbox-2.6.min.js"></script>
        
        
        
    </head>
    
    <body>
    
        <div class="container">
            
            <? include '../nav/navbar.php'; ?>
            
            <div class="row">
                
                <? include '../nav/sidemenu.php'; ?>
                
                 <div class="col-md-8">
                     
                     <h2>What does A&Omega;E do?</h2>
                     <p>
                     
                        Check out the pictures below to see what A&Omega;E Sisters do at events throughout the semester.
                     
                     </p>
                    <div class="image-row">
                        <div class="image-set">
                            <a class="example-image-link" href="../img/album/album1.jpg" data-lightbox="aoe" 
                               title="Sisters after a long night of Prefs during Recruitment 2013">
                                <img class="example-image" src="../img/album/album1.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album2.jpg" data-lightbox="aoe" 
                               title="Recruitment Skit 2013: Bridget Ward's A.O.E. Rendition of 'Thrift Shop'">
                                <img class="example-image" src="../img/album/album2.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album3.jpg" data-lightbox="aoe" 
                               title="The start of Big Sis Week 2013: Mu and Lamda classes hike Humpback">
                                <img class="example-image" src="../img/album/album3.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="image-row" style="margin-top: -16px">
                        <div class="image-set"> 
                            <a class="example-image-link" href="../img/album/album4.jpg" data-lightbox="aoe" 
                               title="Mid Big Sis Week: Lambda class organized a Paint War for the new Mu babies">
                                <img class="example-image" src="../img/album/album4.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album5.jpg" data-lightbox="aoe" 
                               title="Not afraid to get dirty: A.O.E cleans up a trail for Spring 2013 Community Service">
                                <img class="example-image" src="../img/album/album5.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album6.jpg" data-lightbox="aoe" 
                               title="Mu class has some of the biggest UVa football fans you'll find anywhere">
                                <img class="example-image" src="../img/album/album6.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="image-row" style="margin-top: -16px">
                        <div class="image-set"> 
                            <a class="example-image-link" href="../img/album/album7.jpg" data-lightbox="aoe" 
                               title="Throw what you know! A.O.E. does Foxfield 2013">
                                <img class="example-image" src="../img/album/album7.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album9.jpg" data-lightbox="aoe" 
                               title="First sisterhood event of Fall 2013: Bikram Hot Yoga on the Downtown Mall">
                                <img class="example-image" src="../img/album/album9.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album10.jpg" data-lightbox="aoe" 
                               title="Fall 2013 Day Away: a trip to Fright Fest at Kings Dominion...and boy were we frightened">
                                <img class="example-image" src="../img/album/album10.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                        </div>
                    </div>
                     <br>
                    <div class="image-row" style="margin-top: -16px">
                        <div class="image-set"> 
                            <a class="example-image-link" href="../img/album/album8.jpg" data-lightbox="aoe" 
                               title="Last Homecomings for the class of 2014: 4 years in A.O.E. and 4 years of friendship!">
                                <img class="example-image" src="../img/album/album8.jpg" alt="" 
                                     width="132" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album16.jpg" data-lightbox="aoe" 
                               title="But Lambda class loves Homecomings too!">
                                <img class="example-image" src="../img/album/album16.jpg" alt="" 
                                     width="132" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album11.jpg" data-lightbox="aoe" 
                               title="DFunc for Fall 2013: Mathletes and Athletes...we stick to our strengths!">
                                <img class="example-image" src="../img/album/album11.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album12.jpg" data-lightbox="aoe" 
                               title="Expert Bakers: Fall 2013 Philanthropy got everyone involved in a Cake Walk in Darden Court">
                                <img class="example-image" src="../img/album/album12.jpg" alt="" 
                                     width="132" height="150"/>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="image-row" style="margin-top: -16px">
                        <div class="image-set"> 
                            <a class="example-image-link" href="../img/album/album13.jpg" data-lightbox="aoe" 
                               title="Though not an A.O.E. event, sisters show their love for the E-School at the 2013 
                                      Engineering Rotunda Dinner">
                                <img class="example-image" src="../img/album/album13.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album14.jpg" data-lightbox="aoe" 
                               title="Grand-bigs, Bigs, and Littles reuinted during the A.O.E. Homecomings Tailgate 2013">
                                <img class="example-image" src="../img/album/album14.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                            <a class="example-image-link" href="../img/album/album15.jpg" data-lightbox="aoe" 
                               title="Some of our alums love us so much they'll fly all the way from San Francisco just for tailgates!">
                                <img class="example-image" src="../img/album/album15.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="image-row" style="margin-top: -16px">
                        <div class="image-set"> 
                            <a class="example-image-link" href="../img/album/album17.jpg" data-lightbox="aoe" 
                               title="Day Away Spring 2013: Bigs revealed, and all families gained new additions!">
                                <img class="example-image" src="../img/album/album17.jpg" alt="" 
                                     width="200" height="150"/>
                            </a>
                        </div>
                    </div>
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