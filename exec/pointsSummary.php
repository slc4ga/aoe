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
    <h2 style="color:#0088cc"> Points Summary </h2>
    <div class="alert alert-warning" role="alert">
        <strong>Warning!</strong> Right now, each new summary takes about 20 seconds to load. 
        The webmaster is working on speeding it up, but be patient for now!
    </div>
    <hr>
<!--
    month/year drop down
    count of sisters who met monthly quota
    export to email list
    list all active sisters
    highlight green if met monthly quota
-->
    
    <div class="row">
        <div class="col-md-8">
            <select id="month" name="month" class="form-control">
                <option value="total">Total</option>
                <?
                    $dateRange = $mysql->getDateRange();
                    $dateArray = mysqli_fetch_array($dateRange);
                    $curDate = strtotime($dateArray[0]);    // start at min date
                    $maxDate = strtotime($dateArray[1]);
                    while($curDate < $maxDate) {
                        echo "<option value='" . date('n/Y', $curDate) . "'";
                        if(date('n/Y', $curDate) == date('n/Y', time())) {
                            echo " selected";
                        }
                        echo ">" . date('F Y', $curDate) . "</option>";
                        $curDate = strtotime("+1 month", $curDate);
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" id="sumSubmit" name="sumSubmit" onclick="summary()">Get Summary</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="summaryInfo"></div>
        </div>
    </div>
</div>