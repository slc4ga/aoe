<?php
	include_once('../nav/mysql.php');
    include_once('../nav/constants.php');
	session_start();
	$mysql = new Mysql();
    date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }
?>

<div id="points" class='col-md-11'>
    <h2 style="color:#0088cc"> Points Summary</h2>
    <?
        $userPoints = $mysql->getPointsInMonthForUser($_SESSION['user_id']);
        $monthPoints = $mysql->getPointsInMonth();
       
        echo "<h4 id='monthly-points'>" . date('F', time()) . " points <em>so far</em>: " . $userPoints . "/" . $monthPoints . "</h4>";
        echo "<h4 id='monthly-points'>Total points overall: " . $mysql->getTotalPointsForOneUser($_SESSION['user_id']) . "/" . 
                $mysql->getTotalPointsOverall() . "</h4>";

        $daysLeft = date('t', time()) - date('d', time());
        if($daysLeft < 10) {
            if($monthPoints > 0 && $userPoints/$monthPoints < POINTS_QUOTA) {
                echo '<div class="alert alert-danger" role="alert">';
                echo "  <strong>Uh oh!</strong> There are only $daysLeft days left in " . date('F', time()) . 
                    " and you haven't quite met the points quota...make sure you get all your points entered!";
                echo '</div>';
            }
        }
        if($monthPoints > 0 && $userPoints/$monthPoints > POINTS_QUOTA) {
            echo '<div class="alert alert-success" role="alert">';
            echo "  <strong>Great job!</strong> There are  $daysLeft days left in " . date('F', time()) . 
                " and you've already met your attendance requirements!";
            echo '</div>';
        }
    ?>
    <div id="addsuccess"></div>
    <hr>
    <div class="panel-group" id="accordion">
        <? 
            $result = $mysql->getPointsCategories();
            while ($row = mysqli_fetch_array($result)) {
                echo '<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#' . $row[0] . '">';
                                    echo $row[1];
                echo '          </a>
                                <div class="pull-right" id="' . $row[0] . '-points">
                                    ' . $mysql->getPointsInCategoryForUser($row[0]) . '/' . $mysql->getPointsInCategory($row[0]) . '
                                </div>
                            </h4>
                        </div>
                        <div id="' . $row[0] . '" class="panel-collapse collapse">
                            <div class="panel-body">';
                                // baby event form
                                $isMandatory = $mysql->checkCategoryIsMandatory($row[0]);
                                if($isMandatory == 0) {
                                   echo "<p style='text-align: center'><em>
                                        Remember - these points aren't counted towards your monthly totals!
                                        </em></p>"; 
                                    $mysql->addBabyEventForm($row[0]);
                                } 
                                // chapter
                                if($row[0] == 9) {
                                    echo "<div id='chapterLoginMessage'></div>
                                            <div id='chapterLoginButton'>";
                                    $today = date('Y-m-d', time());
                                    if(date('w', time()) == '0' && $mysql->checkChapterMade($today) == 1) { // if sunday
                                        $today = date('Y-m-d', time());
                                        $today_formatted = date('n/j/Y', time());
                                        
                                        if(time() > strtotime("7:50 PM") && time() < strtotime("8:15 PM")) { //on time
                                            if($mysql->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                                                echo "<div class='row'>
                                                    <div class='col-md-4 col-md-offset-4'>";
                                                echo "<button style='width: 100%' class='btn btn-lg btn-success' onclick=\"ontimeChapter('"
                                                    . $_SESSION['user_id'] . "','" . $today . "')\">Check In <br>
                                                    ($today_formatted)</button>";
                                                echo "  </div>
                                                  </div>";
                                            } else {
                                                echo "<div class='row'>
                                                        <div class='col-md-6 col-md-offset-3'>
                                                            <h5>Thanks, you've already checked in today!</h5>
                                                        </div>
                                                    </div>";    
                                            }
                                        } else if(time() < strtotime("8:20 PM")) { // late
                                                if($mysql->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                                                    echo "<div class='row'>
                                                            <div class='col-md-4 col-md-offset-4'>";
                                                    echo "<button style='width: 100%' class='btn btn-lg btn-warning'
                                                            onclick=\"lateChapter('" . $_SESSION['user_id'] . "','" . $today . "')\">
                                                                Check In <br> ($today_formatted)</button>";
                                                    echo "  </div>
                                                        </div>";
                                                } else {
                                                    echo "<div class='row'>
                                                            <div class='col-md-6 col-md-offset-3'>
                                                                <h5>Thanks, you've already checked in today!</h5>
                                                            </div>
                                                        </div>";    
                                                }
                                        } else if(time() < strtotime("9:15 PM")) { // too late
                                            if($mysql->checkChapterAttendance($_SESSION['user_id'], date('Y-m-d', time())) == 0) {
                                                echo "<div class='row'>
                                                    <div class='col-md-12'>";
                                                echo "<div class='alert alert-danger' role='alert'>
                                                        <strong>Oh snap!</strong> You were too late to chapter to check in. 
                                                        Try to be on time next time!
                                                    </div>";
                                                echo "</div>
                                                    </div>";
                                            }
                                        }
                                    }
                                    echo "</div>";
                                    echo "<br>";
                                    $chaps = $mysql->getChapters();
                                    if($chaps->num_rows == 0) {
                                        echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
                                    } else {
                                        while ($chapter = mysqli_fetch_array($chaps)) {
                                            $chapter_date = date('n/j/Y', strtotime($chapter[0]));
                                            $chapter_date_formatted = date('Y-m-d', strtotime($chapter[0]));
                                            $chapter_result = $mysql->checkChapterPoints($_SESSION['user_id'], $chapter_date_formatted);
                                            $pointsArray = mysqli_fetch_array($chapter_result);
                                            $points = $pointsArray[0];
                                            echo "<div class='col-md-4 chapter";
                                                //check attendance submittal
                                                
                                                if($chapter_date_formatted <= date('Y-m-d', time())) {                                                        
                                                    // if red
                                                    if($chapter_result->num_rows == 0) {
                                                        if(date('G:i' , time()) > date('G:i', strtotime("9:00 PM"))){
                                                            echo " missed";   
                                                        }
                                                    }
                                                    // if yellow
                                                    else if($points == 2) {
                                                        echo " late";    
                                                    }
                                                    // else green
                                                    else {
                                                        echo " ontime";    
                                                    }
                                                    echo "'>";
                                                    echo $chapter_date;
                                                } else {
                                                    echo "'>";
                                                    echo $chapter_date;
                                                }
                                            echo "</div>";

                                        }
                                    }
                                }
                                // chair position
                                else if($row[0] == 10) {
                                    echo "<p><em>
                                            Remember - these points aren't counted towards your monthly totals! 
                                            You should receive " . CHAIR_POINTS . " points per chair position listed here.
                                          </em></p>";
                                    $chairs = $mysql->getChairPositionPoints($_SESSION['user_id']);
                                    while($pos = mysqli_fetch_array($chairs, MYSQLI_ASSOC)) {
                                        echo "<h5 style='text-align: center'>" . $pos["name"] . "</h5>";
                                    }
                                }
                                // committee position
                                else if($row[0] == 11) {
                                    echo "<p><em>
                                            Remember - these points aren't counted towards your monthly totals! 
                                            You should receive " . COMMITTEE_POINTS . " points per committee position listed here.
                                          </em></p>";
                                    $chairs = $mysql->getCommitteePositionPoints($_SESSION['user_id']);
                                    while($pos = mysqli_fetch_array($chairs, MYSQLI_ASSOC)) {
                                        echo "<h5 style='text-align: center'>" . $pos["name"] . "</h5>";
                                    }
                                }
                                // all other categories
                                else {
                                    $events = $mysql->getEventsInCategory($row[0]);
                                    if($events->num_rows == 0) {
                                        echo "<p style='text-align:center'><em>No events in this category yet!</em></p>";    
                                    } else {
                                        echo "<table class='table table-hover'>
                                                <tbody>";
                                            while($individualEvent = mysqli_fetch_array($events)) {  
                                                $approved = $mysql->checkAttendanceApproval($_SESSION['user_id'], $individualEvent[0]);
                                                echo "<tr";
                                                if($approved == 1) {
                                                    echo " class=\"success\"";
                                                }
                                                echo      ">
                                                        <td>$individualEvent[1]<br><em>$individualEvent[4] points</em></td>
                                                        <td>" . date('n/j/Y', strtotime($individualEvent[3])) . "</td>
                                                        <td style='text-align: center'>";
                                                        if($mysql->checkAttendance($_SESSION['user_id'], $individualEvent[0]) == 0) {
                                                            echo "<button onclick='submitAttendance($individualEvent[0], $row[0])' 
                                                                    class='btn btn-success'>
                                                                        I attended
                                                                </button>";
                                                        }
                                                echo "  </td>
                                                      </tr>";
                                            }
                                        echo "  </tbody>
                                              </table>";
                                    }
                                    
                                    $events = $mysql->getUnapprovedEventsInCategory($row[0]);
                                    if($events->num_rows > 0) {
                                        echo "<hr><p>The following events have been entered, but have not been approved by exec yet: </p
                                                ><br>";
                                        echo "<table class='table table-hover'>
                                                <tbody>";
                                            while($individualEvent = mysqli_fetch_array($events)) {  
                                                $approved = $mysql->checkAttendanceApproval($_SESSION['user_id'], $individualEvent[0]);
                                                echo "<tr";
                                                if($approved == 1) {
                                                    echo " class=\"success\"";
                                                }
                                                echo      ">
                                                        <td><em>$individualEvent[1]</em></td>
                                                        <td><em>" . date('n/j/Y', strtotime($individualEvent[3])) . "</em></td>
                                                      </tr>";
                                            }
                                        echo "  </tbody>
                                              </table>";
                                    }
                                }
                echo '      </div>
                        </div>
                    </div>';
            }
        ?>
    </div>
</div>
<script type="text/javascript">
    if(add === 'success') {
        $('#addsuccess').html(
          "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span> </button> <strong>Nice!</strong> Your event was added, and will appear once it has been approved by exec.</div>"  
        );
    }
</script>