<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    $user = $_GET['id'];

    $row = $mysql->getInfo($user)->fetch_array(MYSQLI_NUM);

    $class = $row[3] . " Class";
    if (strpos($class,'Alumnae') !== false) {
        $class = "Alumnae";
    }

    $url = $mysql->getURL($row[3]);
?>

    <div class="row">
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li><a href="sisters.php?select=1">Sisters</a></li>
                <li><a href="<? echo $url; ?>"><? echo $class; ?></a></li>
                <li class="active"><? echo $mysql->getFullName($user); ?></li>
            </ol>
        </div>
    </div>

    <h2 style="color:#0088cc"> <? echo $mysql->getFullName($user); ?> </h2>
    <?
        //check leadership
        $pos = $mysql->getLeadership($user);
        $num = $pos->num_rows;
        while ($row1 = mysqli_fetch_array($pos, MYSQL_NUM)) {
                echo "<h4>" . $row1[0] . "</h4>";
        }

    ?>
    <hr>
    <div class="row">
        <div class="col-md-5">
            <?
                $imgPath=strtolower("../img/" . $user . ".jpg");
                echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                height: 300px; width: 250px\">";
                if(file_exists($imgPath)) {
                    $imgPath=strtolower("http://alphaomegaepsilonatuva.com/img/" . $user . ".jpg?" . Time());
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
            <span style="font-size:1.25em"><b> Major: </b></span><br> 
                <?
                    echo "<p>" . $row[7];
                    if(isset($row[8])) {
                        echo "<br>" . $row[8]; 
                    }
                    echo "</p>";
                ?>
            <?
                if(isset($row[9]) && strlen($row[9]) > 0) {
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
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
            <?
                     if(isset($row[12]) && strlen($row[12]) > 0) { 
                              echo "<span style=\"font-size:1.25em\"><br><b> Bio: </b></span><br>";
                              $row[12] = str_replace("AOE", "A&Omega;E", $row[12]);
                              echo $row[12];
                     }
            ?>
            <br>
        </div>
    </div>

		