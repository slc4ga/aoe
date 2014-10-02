<?
    include_once('../nav/mysql.php');
	session_start();

	$mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

?>

<div class="col-md-11">
                     
    <h2>Sister Testimonials</h2>
    <p>
    
        Use the table below to approve a new sister testimonial to display on the public site.
    
    </p>
    <br>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3> Pending Testimonials </h3>
            <? 
        
                $num = $mysql->getTestimonialNums();
                if($num == 0) {
                    echo "<h4> You have no pending testimonials in the database right now </h4>";  
                } else {
                    // req_id, developer id num, category, user details, dev details, urgency, completed sort by completed
                    echo "<form method=\"post\" action=\"approveTestimonials.php\"> <fieldset> 
                        <table class=\"table table-hover\">  
                        <thead>  
                        <tr>  
                        <th>Name</th>  
                        <th>Testimonial</th>
                        <th>Approve?</th>
                        <th>Delete?</th>
                        </tr>  
                        </thead>  
                        <tbody> ";
            
                        $result=$mysql->getAllPendingTestimonials();
                        if (gettype($result) == "boolean") {
                            echo "failed<br>";
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td><a class='inline' href=\"#" . $row[0] . "\">" . $row[1] . "</a></td>";
                                $array = explode(" ", $row[2]);
                                echo "<td>" . $array[0] . " " . $array[1] . " " . $array[2] . " " . $array[3] . " " . 
                                    $array[4] . "...</td>";
                                // checkboxes
                                echo "<td><div class=\"controls\"><input name=\"cb".$row['0']."\"type=\"checkbox\" 
                                        ></label></div></td>";
                                echo "<td>" . "<a class=\"btn btn-sm btn-danger\" href=\"deleteTestimonial.php?req=$row[0]\">
                                                Delete</a></td>";
                                echo "</tr>";
                                
                                // now make hidden box
                                echo "<div style='display:none'>";
                                    echo "<div id='" . $row[0] . "' style='padding:10px; background:#fff;'>";
                                         echo "<h2>" . $mysql->getFullName($row[1]) . "</h2>";
                                         echo "<br><p><b>Message: </b><br> <em>" . $row[2] . "</em><br><br>";  
                                         echo"</p>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }
                        echo "</tbody>  
                        </table>  
                        <div class=\"form-actions\">  
                           <input class=\"btn btn-success\" id=\"Approve\" name=\"approve\" type=\"submit\" 
                                style=\"float:right\" value=\"Approve\">
                        </div>
                        </form>
                        </fieldset>";
                }
            ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3> Approved Testimonials </h3>
            <?
                $num = $mysql->getApprovedTestimonialNums();
                if($num == 0) {
                    echo "<h4> You have no approved testimonials in the database right now </h4>";  
                } else {
                    // req_id, developer id num, category, user details, dev details, urgency, completed sort by completed
                    echo "<form method=\"post\" action=\"approveTestimonials.php\">
                        <table class=\"table table-hover\">  
                        <thead>  
                        <tr>  
                        <th>Name</th>  
                        <th>Testimonial</th>
                        <th>Delete?</th>
                        </tr>  
                        </thead>  
                        <tbody> ";
            
                        $result=$mysql->getAllApprovedTestimonials();
                        if (gettype($result) == "boolean") {
                            echo "failed<br>";
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td><a class='inline' href=\"#" . $row[0] . "\">" . $row[1] . "</a></td>";
                                $array = explode(" ", $row[2]);
                                echo "<td>" . $array[0] . " " . $array[1] . " " . $array[2] . " " . $array[3] . " " . 
                                    $array[4] . "...</td>";
                                // checkboxes
                                echo "<td>" . "<a class=\"btn btn-sm btn-danger\" href=\"deleteTestimonial.php?req=$row[0]\">
                                                Delete</a></td>";
                                echo "</tr>";
                                
                                // now make hidden box
                                echo "<div style='display:none'>";
                                    echo "<div id='" . $row[0] . "' style='padding:10px; background:#fff;'>";
                                         echo "<h2>" . $mysql->getFullName($row[1]) . "</h2>";
                                         echo "<br><p><b>Message: </b><br> <em>" . $row[2] . "</em><br><br>";  
                                         echo"</p>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }
                        echo "</tbody>  
                        </table>  
                        </form>";
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