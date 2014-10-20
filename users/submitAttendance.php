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
        // chapter
        if($catId == 9) {
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
        else if($catId == 10) {
            echo "<p style='text-align:center'>
                    Update leadership to allocate chair position points.
                  </p>";
        }
        // committee position
        else if($catId == 11) {
            echo "<p style='text-align:center'>
                    Update leadership to allocate committee position points.
                   </p>";
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
                        echo "<tr>
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
        }
echo '</div>';
   
    

?>