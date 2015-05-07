<?
    require_once '../nav/mysql.php';
    require_once '../nav/constants.php';

    $mysql = new Mysql();
    session_start();
   date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

    $eventId = $_GET['id'];
    $points = $_GET['points'];
    $cat = $_GET['divId'];

    $mysql->approveBabyEvent($eventId, $points);

    echo "<div class=\"panel-body\">";
        // chapter
        if($cat == 9) {
            include 'chapterForm.php';
            echo "<br>";
            $chaps = $mysql->getChapters();
            if($chaps->num_rows == 0) {
                echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
            } else {
                while ($chapter = mysqli_fetch_array($chaps)) {
                    echo "<div class='col-md-4 chapter'>";
                        echo date('n/j/Y', strtotime($chapter[0])) . " ($chapter[1])";
                    echo "</div>";

                }
            }
        }
        // chair position
        else if($cat == 10) {
            echo "<p style='text-align:center'>
                    Update leadership to allocate chair position points.
                  </p>";
        }
        // committee position
        else if($cat == 11) {
            echo "<p style='text-align:center'>
                    Update leadership to allocate committee position points.
                   </p>";
        }
        // all other categories
        else {
            $events = $mysql->getEventsInCategory($cat);
            if($events->num_rows == 0) {
                echo "<p style='text-align:center'><em>No events in this category yet!</em></p>";    
            } else {
                echo "<table class='table table-hover'>
                        <tbody>";
                    while($individualEvent = mysqli_fetch_array($events)) {                                              
                        echo "<tr>
                                <td>$individualEvent[1]<br><em>$individualEvent[4] points</em></td>
                                <td>" . date('n/j/Y', strtotime($individualEvent[3])) . "</td>
                                <td style='text-align: center'>
                                    <button onclick='deleteEvent($individualEvent[0], $cat)' 
                                        class='btn btn-danger'>
                                            Delete Event
                                    </button>
                                </td>
                              </tr>";
                    }
                echo "  </tbody>
                      </table>";
            }

            $events = $mysql->getUnapprovedEventsInCategory($cat);
            if($events->num_rows > 0) {
                echo "<hr><p>The following events have been entered, but have not been approved yet: </p
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
                                <td style='text-align: center'>
                                    <button onclick='approveEvent($individualEvent[0], $cat)' 
                                        class='btn btn-info'>
                                            Approve Event
                                    </button>
                                    <button onclick='deleteEvent($individualEvent[0], $cat)' 
                                        class='btn btn-danger'>
                                            Delete Event
                                    </button>
                                </td>
                              </tr>";
                    }
                echo "  </tbody>
                      </table>";
            }
        }
    echo '</div>';
?>