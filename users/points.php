<?php
	include_once('../nav/mysql.php');
    include_once('../nav/constants.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }
?>

<div id="points" class='col-md-11'>
    <h2 style="color:#0088cc"> Points Summary</h2>
    <?
        $userPoints = $mysql->getPointsInMonthForUser($_SESSION['user_id']);
        $monthPoints = $mysql->getPointsInMonth();
        echo "<h4 id='monthly-points'>" . date('F', time()) . " points: " . $userPoints . "/" . $monthPoints . "</h4>";

        $daysLeft = date('t', time()) - date('d', time());
        if($daysLeft < 10) {
            if($userPoints/$monthPoints < POINTS_QUOTA) {
                echo '<div class="alert alert-danger" role="alert">';
                echo "  <strong>Uh oh!</strong> There are only $daysLeft days left in " . date('F', time()) . 
                    " and you haven't quite met the points quota...make sure you get all your points entered!";
                echo '</div>';
            }
        }
        if($userPoints/$monthPoints > POINTS_QUOTA) {
            echo '<div class="alert alert-success" role="alert">';
            echo "  <strong>Great job!</strong> There are  $daysLeft days left in " . date('F', time()) . 
                " and you've already met your attendance requirements!";
            echo '</div>';
        }
    ?>
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
                                // chapter
                                if($row[0] == 9) {
                                    echo "<div id='chapterLoginMessage'></div>
                                            <div id='chapterLoginButton'>";
                                    if(date('w', time()) == '0') { // if sunday
                                        $today = date('Y-m-d', time());
                                        $today_formatted = date('n/j/Y', time());
                                        
                                        if(time() < strtotime("7:50 PM") && time() < strtotime("8:05 PM")) { //on time
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
                                        } else if(time() < strtotime("8:15 PM")) { // late
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
                                    echo "</div>";
                                    echo "<br>";
                                    $chaps = $mysql->getChapters();
                                    if($chaps->num_rows == 0) {
                                        echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
                                    } else {
                                        while ($chapter = mysqli_fetch_array($chaps)) {
                                            echo "<div class='col-md-4 chapter'>";
                                                echo date('n/j/Y', strtotime($chapter[0]));
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
                                                echo "<tr>
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
                                }
                echo '      </div>
                        </div>
                    </div>';
            }
        ?>
    </div>
</div>