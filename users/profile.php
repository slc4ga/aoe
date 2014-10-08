<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


    $row = $mysql->getInfo($_SESSION['user_id'])->fetch_array(MYSQLI_NUM);

?>

<div id="profile" class='col-md-11'>
    <h2 style="color:#0088cc"> <? echo $mysql->getFullName($_SESSION['user_id']); ?> </h2>
    <?
        //check leadership
        $pos = $mysql->getLeadership($_SESSION['user_id']);
        $num = $pos->num_rows;
        while ($row1 = mysqli_fetch_array($pos, MYSQL_NUM)) {
                echo "<h4>" . $row1[0] . "</h4>";
        }
    ?>
    <hr>
    <div class="row">
        <div class="col-md-5">
            <?
                $imgPath="../img/" . $_SESSION['user_id'] . ".jpg";
                echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                height: 300px; width: 250px\">";
                if(file_exists($imgPath)) {
                    $imgPath="http://alphaomegaepsilonatuva.com/img/" . $_SESSION['user_id'] . ".jpg?" . Time();
                    echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                } else {
                    echo "<br><br><br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                }
                echo "</div>";
            ?>
        </div>
        <div class="col-md-6">
            <span style="font-size:1.25em"><b> Pledge Class: </b></span>
                <? echo $row[3]; ?>
            <br>
            <span style="font-size:1.25em"><b> Year: </b></span> 
                <? echo $row[4]; ?>
            <br>
            <span style="font-size:1.25em"><b> Hometown: </b></span> 
            <? 
                    if(isset($row[5]) && strlen($row[5]) > 0) {
                        echo $row[5];
                        if(isset($row[6])) {
                               echo ", " . $row[6]; 
                        }
                    }
                    else if(isset($row[6])) {
                        echo $row[6];
                    }
                ?>
            <br><br>
            <span style="font-size:1.25em"><b> Major: </b></span> <br>
                <?
                    echo "<p>" . $row[7];
                    if(isset($row[8])) {
                        echo "<br>" . $row[8]; 
                    }
                    echo "</p>";
                ?>
            <?
                if(isset($row[9]) && strlen($row[9] > 0)) {
                    echo "<br><span style=\"font-size:1.25em\"><b> Minor: </b></span><br> ";
                    echo "<p>" . $row[9];
                    if(isset($row[10])) {
                        echo "<br>" . $row[10];
                    }
                    echo "</p>";
                }
            ?>
            <br>
            <span style="font-size:1.25em"><b> Activities: </b></span> 
                    <? 
                        $array = explode("\n", $row[11]);
                        if(count($array) - 1 > 0) {
                            echo "<ul>";
                            for($i = 0; $i < count($array); ++$i) {
                                $array[$i] = str_replace("AOE", "A&Omega;E", $array[$i]);
                                if(strlen($array[$i]) > 0) { echo "<li>" . $array[$i] . "</li>"; }
                            }
                            echo "</ul>";
                        }
                        if(count($array) - 1 == 0 && strlen($row[11]) > 0) {
                            echo "<ul><li>" . $row[11] . "</li></ul>";
                        }
                    ?>
            <br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span style="font-size:1.25em"><b> Bio: </b></span><br>
                <? 
                        $row[12] = str_replace("AOE", "A&Omega;E", $row[12]);
                        echo $row[12]; 
                 ?>
            <br>
        </div>
    </div>
</div>
		