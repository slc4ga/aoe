<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

?>

<div class="col-md-11">
                     
    <h2>Anonymous Feedback</h2>
    <p>
        Use the table below to view and acknowledge anonymous feedback. <strong>Please note that acknowleging a feedback entry will no 
        longer display it in the table below.</strong>
    </p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?
                $result=$mysql->getAllUnacknowledgedFeedback();
                if($result->num_rows == 0) {
                    echo "<h4> You have no anonymous feedback right now.</h4>";  
                } else {
                    // req_id, developer id num, category, user details, dev details, urgency, completed sort by completed
                    echo "  <table class=\"table table-hover\">  
                                <thead>  
                                    <th>Date</th>  
                                    <th>Feedback</th>
                                    <th>Acknowledge?</th> 
                                </thead>  
                                <tbody> ";  
            
                        if (gettype($result) == "boolean") {
                            echo "failed<br>";
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . date('n/j/Y', strtotime($row[2])) . "</td>";
                                $array = explode(" ", $row[1]);
                                echo "<td><a class='inline' href=\"#" . $row[0] . "\">" . $array[0] . " " . $array[1] . " " . $array[2] . " " . $array[3] . " " . 
                                    $array[4] . "...</a></td>";
                                // checkboxes
                                echo "<td>" . "<a class=\"btn btn-sm btn-warning\" href=\"acknowledgeFeedback.php?req=$row[0]\">
                                                Acknowledge</a></td>";
                                echo "</tr>";
                                
                                // now make hidden box
                                echo "<div style='display:none'>";
                                    echo "<div id='" . $row[0] . "' style='padding:10px; background:#fff;'>";
                                         echo "<h4>Full Feedback - " . date('n/j/Y', strtotime($row[2])). "</h4>";
                                         echo "<br><p>" . $row[1] . "</em><br><br>";  
                                         echo"</p>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }
                        echo "</tbody>  
                        </table>";
                }
            ?>
        </div>
    </div>
    </div>

        
<script src="../bootstrap/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
           $(".inline").colorbox({inline:true, width:"50%"});
    });
</script>