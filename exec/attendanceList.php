<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) == 1 || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location: ../index.php");
    }
?>

<div id="points" class='col-md-11'>
    <h2 style="color:#0088cc"> Event Attendance </h2>
    <hr>
<!--
    semester drop down
    accordion of events
    sister names with checkboxes
    approve all checked
-->
    
    <div class="row">
        <div class="col-md-8">
            <select id="semester" name="semester" class="form-control">
                <?
                    $dateRange = $mysql->getSemesterStart();
                    $dateArray = mysqli_fetch_array($dateRange);
                    $curDate = strtotime($dateArray[0]);    // start at min date
                    $maxDate = time();
                    echo $curDate . " " . $maxDate;
                    while($curDate < $maxDate) {
                        echo "<option value='";
                        if(date('n', $curDate) == 1 || date('n', $curDate) <= 7) {
                            // first half of the year
                            echo date('Y', $curDate) . " - 1";
                        } else {
                            echo date('Y', $curDate) . " - 8";   
                        }
                        echo "'";
                        if(date('n/Y', $curDate) == date('n/Y', time())) {
                            echo " selected";
                        }
                        echo ">";
                        if(date('n', $curDate) == 1 || date('n', $curDate) <= 7) {
                            // first half of the year
                            echo "Spring " . date('Y', $curDate);
                        } else {
                            echo "Fall " . date('Y', $curDate);   
                        }
                        echo "</option>";
                        $curDate = strtotime("+6 month", $curDate);
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" id="sumSubmit" name="sumSubmit" onclick="semesterEvents()">Get Semester Events</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="semesterEvents"></div>
        </div>
    </div>
</div>