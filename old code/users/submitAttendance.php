<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location:../index.php");
    }

    $eventId = $_GET['eventId'];
    $catId = $_GET['catId'];
    
    $mysql->submitAttendance($_SESSION['user_id'], $eventId);

echo ' <div class="panel-body">';
                // baby event form
                $isMandatory = $mysql->checkCategoryIsMandatory($catId);
                if($isMandatory == 0) {
                   echo "<p style='text-align: center'><em>
                        Remember - these points aren't counted towards your monthly totals!
                        </em></p>"; 
                    $mysql->addBabyEventForm($catId);
                } 
                // chapter
                if($catId == 9) {
                    echo "<div id='chapterLoginMessage'></div>
                            <div id='chapterLoginButton'>";
                    $today = date('Y-m-d', time());
                    if(date('w', time()) == '0' && $mysql->checkChapterMade($today) >= 1) { // if sunday
                        $today = date('Y-m-d', time());
                        $today_formatted = date('n/j/Y', time());

                        if(time() > strtotime("7:50 PM") && time() < strtotime("10:00 PM")) { //on time
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
                        } else if(time() > strtotime("8:10 PM") && time() < strtotime("8:20 PM")) { // late
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
                        } else if(time() > strtotime("8:20 PM") && time() < strtotime("9:15 PM")) { // too late
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
                                        if($chapter_date_formatted < date('Y-m-d', time())) {
                                            echo " missed"; 
                                        } else if (date('G:i' , time()) > date('G:i', strtotime("9:00 PM"))) {
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
                else if($catId == 10) {
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
                else if($catId == 11) {
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
                    $events = $mysql->getEventsInCategory($catId);
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
                                            echo "<button onclick='submitAttendance($individualEvent[0], $catId)' 
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

                    $events = $mysql->getUnapprovedEventsInCategory($catId);
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
echo '      </div>';
?>