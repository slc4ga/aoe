<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();
    
    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $id = $_GET['id'];
    $divId = $_GET['divId'];
    
    $mysql->deleteEvent($id);

    echo '<div class="panel-body">';
            // chapter
            if($id == 9) {

            }
            // chair position
            else if($id == 10) {
                echo "<p style='text-align:center'>
                        Update leadership to allocate chair position points.
                      </p>";
            }
            // committee position
            else if($id == 11) {
                echo "<p style='text-align:center'>
                        Update leadership to allocate committee position points.
                       </p>";
            }
            // all other categories
            else {
                $events = $mysql->getEventsInCategory($divId);
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
                                        <button onclick=deleteEvent($id, $divId) class='btn btn-danger'>Delete Event</button>
                                    </td>
                                  </tr>";
                        }
                    echo "  </tbody>
                          </table>";
                }
            }
echo '</div>';

?>