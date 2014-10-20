<?
	include_once('../nav/mysql.php');
    include_once('../nav/constants.php');
	session_start();
    date_default_timezone_set('America/New_York');
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location: ../index.php");
    }

    $date = explode(" - ", $_GET['date']);
    $date = strtotime("$date[0]-$date[1]");
?>
<h3>Semester Events</h3>
<div class="panel-group" id="accordion">
<?
    $events = $mysql->getSemesterEvents($date);
    while($eventInfo = mysqli_fetch_array($events)) { 
        $attendance = $mysql->getEventAttendance($eventInfo[0]);  
        echo " <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                      <h4 class=\"panel-title\">
                        <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#$eventInfo[0]\">
                          $eventInfo[1] - " . date('n/j/Y', strtotime($eventInfo[3])) . "
                        </a>
                        <div class=\"pull-right\" id=\"" . $row[0] . "-points\">
                            <em>(" . $attendance->num_rows . ")</em>
                        </div>
                      </h4>
                    </div>
                    <div id=\"$eventInfo[0]\" class=\"panel-collapse collapse\">
                      <div class=\"panel-body\">
                        ";
                            
                            if($attendance->num_rows > 0) {
                                echo "<form method=\"post\" action=\"approveAttendance.php\">
                                        <input type=\"hidden\" id='eventID' name='eventID' value=\"$eventInfo[0]\" />
                                        <table class=\"table table-hover\">
                                            <thead>
                                                <th>Name</th>
                                                <th>Approve?</th>
                                            </thead>";
                                            while($submittal = mysqli_fetch_array($attendance)) {
                                                echo "<tr>
                                                        <td>" . $mysql->getFullName($submittal[1]) . "</td>";
                                                echo "  <td><div class=\"controls\"><input name=\"cb".$submittal[1]."\"type=\"checkbox\" 
                                                            ></div></td>";
                                                echo " </tr>";
                                            }
                                    echo "</table>
                                        <input type=\"submit\" class=\"btn btn-success\" value=\"Approve Attendance\" />
                                        </form>";
                            } else {
                                echo "<p style=\"text-align: center\">
                                        <em>No sisters have submitted attendance for this event yet.</em>
                                    </p>";    
                            }
        echo "          </div>
                    </div>
                  </div>";
    }
?>
</div>