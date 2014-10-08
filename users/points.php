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
        echo "<h4>" . date('F', time()) . " points: " . $userPoints . "/" . $monthPoints . "</h4>";

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
                                <div class="pull-right">
                                    ' . $mysql->getPointsInCategoryForUser($row[0]) . '/' . $mysql->getPointsInCategory($row[0]) . '
                                </div>
                            </h4>
                        </div>
                        <div id="' . $row[0] . '" class="panel-collapse collapse">
                            <div class="panel-body">';
                                // chapter
                                if($row[0] == 9) {
                                    include 'chapterForm.php';
                                    echo "<br>";
                                    $chaps = $mysql->getChapters();
                                    if($chaps->num_rows == 0) {
                                        echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
                                    } else {
                                        while ($chapter = mysqli_fetch_array($chaps)) {
                                            echo "<div class='col-md-4 chapter'>";
                                                echo date('n/j/Y', strtotime($chapter[3])) . " ($chapter[6])";
                                            echo "</div>";

                                        }
                                    }
                                }
                                // chair position
                                else if($row[0] == 10) {
                                    echo "<p style='text-align:center'>
                                            Update leadership to allocate chair position points.
                                          </p>";
                                }
                                // committee position
                                else if($row[0] == 11) {
                                    echo "<p style='text-align:center'>
                                            Update leadership to allocate committee position points.
                                           </p>";
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