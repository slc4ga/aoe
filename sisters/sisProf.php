<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    $user = $_GET['id'];

    $row = $mysql->getInfo($user)->fetch_array(MYSQLI_NUM);
?>

    <h2 style="color:#0088cc"> <? echo $mysql->getFullName($user); ?> </h2>
    <?
        //check leadership
        $pos = $mysql->getLeadership($user);
        if(isset($pos)) {
            echo "<h3>" . $pos . "</h3>";
        }
    ?>
    <hr>
    <div class="row">
        <div class="col-md-5">
            <?
                $imgPath="../img/" . $user . ".jpg";
                echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                height: 300px; width: 250px\">";
                if(file_exists($imgPath)) {
                    echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                } else {
                    echo "<br><br><br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                }
                echo "</div>";
            ?>
        </div>
        <div class="col-md-7">
            <span style="font-size:1.25em"><b> Pledge Class: </b></span>
                <? echo $row[3]; ?>
            <br>
            <span style="font-size:1.25em"><b> Year: </b></span> 
                <? echo $row[4]; ?>
            <br>
            <span style="font-size:1.25em"><b> Hometown: </b></span> 
                <? 
                    if(isset($row[5]) && isset($row[6])) {
                        echo $row[5] . ", " . $row[6]; 
                    }
                ?>
            <br><br>
            <span style="font-size:1.25em"><b> Major: </b></span> 
                <?
                    echo $row[7] . "<br>";
                    if(isset($row[8])) {
                        echo "<p style=\"margin-left: 59px;\">" . $row[8] . "</p>"; 
                    }
                ?>
            <?
                if(isset($row[9]) && strlen($row[9]) > 0) {
                    echo "<br><span style=\"font-size:1.25em\"><b> Minor: </b></span> ";
                    echo $row[9];
                    if(isset($row[10])) {
                        echo "<br><p style=\"margin-left: 59px;\">" . $row[10] . "</p>";
                    }
                }
            ?>
            <br>
            <span style="font-size:1.25em"><b> Activities: </b></span> 
                    <? 
                        $array = explode("\n", $row[11]);
                        if(count($array) - 1 > 0) {
                            echo "<ul>";
                            for($i = 0; $i < count($array); ++$i) {
                                echo "<li>" . $array[$i] . "</li>";
                            }
                            echo "</ul>";
                        }
                    ?>
            <br><br>
            <span style="font-size:1.25em"><b> Bio: </b></span>
                <? echo $row[12]; ?>
            <br>
        </div>
    </div>

		