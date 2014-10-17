<?
	include_once('../nav/mysql.php');
    include_once('../nav/constants.php');
	session_start();
    date_default_timezone_set('America/New_York');
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $date = explode("/", $_GET['date']);
    $month = $date[0];
    $year = $date[1];

    $date = strtotime("$year-$month");

    echo "<h4>Total points in " . date('F', $date) . ": " . $mysql->getPointsInSpecifiedMonth($date) . "</h4>";
    $sisterList = $mysql->getSisterQuota($date);
    $passingSisters = $sisterList[0];
    $missingSisters = $sisterList[1];
    echo "<h4>Number of sisters who met " . round((float)POINTS_QUOTA * 100 ) . "% quota: " . count($passingSisters) . "</h4>";

    foreach ($passingSisters as $un) {
        $datadump .= $un . "@virginia.edu, ";
        $passingTable .= "<tr class='success'>
                <td>" . $mysql->getFullName($un) . "</td>
                <td>" . $mysql->getPointsInSpecifiedMonthForUser($date, $un) . "</td>
            </tr>";
    }
    $datadump = substr($datadump, 0, -2);

    if (count($passingSisters) > 0) {
        echo "<div class='row'>";
        echo "  <div class=\"col-md-4\">
                    <form action=\"export.php\" method=\"get\">
                        <input type='hidden' value='$datadump' name='list' id='list'/>
                        <input type='hidden' value='$date' name='month' id='month'/>
                        <input type=\"submit\" class=\"btn btn-primary\" style='width: 100%' value=\"Download Email List\">
                    </form>
                </div>
            </div>";
    }
    echo "<br>";
?>
<table class="table table-hover">
    <thead>
        <th>Name</th>
        <th>Points</th>
    </thead>
    <?

        echo $passingTable;

        foreach ($missingSisters as $un) {
            echo "<tr>
                <td>" . $mysql->getFullName($un) . "</td>
                <td>" . $mysql->getPointsInSpecifiedMonthForUser($date, $un) . "</td>
            </tr>";
        }
    ?>
</table>