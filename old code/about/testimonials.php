<?
    include_once '../nav/mysql.php';
    $mysql = New Mysql();
?>

<h2>Sister Testimonials</h2>

<span style="font-size: large"><em>Why did you join A&Omega;E?</em></span>

<hr>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?
            $num = $mysql->getApprovedTestimonialNums();
            if($num == 0) {
                echo "<h4> There are no testimonials in the database right now...be sure to check back later!</h4>";  
            } else {
                // req_id, developer id num, category, user details, dev details, urgency, completed sort by completed
                echo "<table class=\"table table-hover\">    
                    <tbody> ";
        
                    $result=$mysql->getAllApprovedTestimonials();
                    if (gettype($result) == "boolean") {
                        echo "failed<br>";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo $row[2];
                            echo "<br><br><p class=\"text-right\"><em> - " . $mysql->getFullName($row[1]) . "</em></p></tr>";
                            echo "<br><br>";
                        }
                    }
                    echo "</tbody>  
                    </table>  
                    </form>";
            }
        ?>
    </div>
</div>

	 	 