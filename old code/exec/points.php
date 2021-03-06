<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();
   date_default_timezone_set('America/New_York');

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location: ../index.php");
    }
?>

<div id="points" class='col-md-11'>
    <h2 style="color:#0088cc"> Manage Events </h2>
    <div id="addsuccess"></div>
    <div id="exemptsuccess"></div>
    <hr>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <? include 'eventForm.php'; ?>
            <hr>
            <? include 'eventCategoryForm.php'; ?>
        </div>
    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  Chapter Attendance Exemption
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
              <div class="panel-body">
                  <?
                    include 'attendanceExemptionForm.php';
                  ?>
              </div>
            </div>
          </div>
        <? 
            $result = $mysql->getPointsCategories();
            while ($row = mysqli_fetch_array($result)) {
                echo '<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#' . $row[0] . '">';
                                    echo $row[1];
                echo '          </a>
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
                                                echo date('n/j/Y', strtotime($chapter[0])) . " ($chapter[1])";
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
                                                        <td style='text-align: center'>
                                                            <button onclick='deleteEvent($individualEvent[0], $row[0])' 
                                                                class='btn btn-danger'>
                                                                    Delete Event
                                                            </button>
                                                        </td>
                                                      </tr>";
                                            }
                                        echo "  </tbody>
                                              </table>";
                                    }
                                    
                                    $events = $mysql->getUnapprovedEventsInCategory($row[0]);
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
                                                            <button onclick='approveEvent($individualEvent[0], $row[0])' 
                                                                class='btn btn-info'>
                                                                    Approve Event
                                                            </button>
                                                            <button onclick='deleteEvent($individualEvent[0], $row[0])' 
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
          "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span> </button> <strong>Nice!</strong> Your event was added.</div>"  
        );
    } else if(exempt === 'success') {
        $('#exemptsuccess').html(
          "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span> </button> <strong>Nice!</strong> Your attendance exemption was added.</div>"  
        );
    }
</script>