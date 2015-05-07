<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

?>

<div id="calendar" class='col-md-12'>
    <h2 style="color:#0088cc"> A&Omega;E Events Calendar </h2>
    <hr>
    <div class="row">
        <div class="col-md-11">
           <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=virginia.edu_kl60i8o89pj0cbhp43qhe90ihs%40group.calendar.google.com&amp;color=%2328754E&amp;ctz=America%2FNew_York" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
        </div>
    </div>
</div>
		