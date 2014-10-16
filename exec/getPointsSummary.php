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
    $passingSisters = $mysql->getSisterQuota($date);
    echo "<h4>Number of sisters who met " . round((float)POINTS_QUOTA * 100 ) . "% quota: " . count($passingSisters) . "</h4>";

        echo "<div class='row'>";
    echo "  <div class=\"col-md-4\">
                <form action=\"export.php\" method=\"get\">
                    <input type='hidden' value='$date' name='month' id='month'/>
                    <input type=\"submit\" class=\"btn btn-primary\" style='width: 100%' value=\"Download Email List\">
                </form>
            </div>
        </div><br>";
?>
<table class="table table-hover">
    <?
        foreach ($passingSisters as $un) {
            echo "<tr class='success'>
                    <td>" . $mysql->getFullName($un) . "</td>
                    <td>" . $mysql->getPointsInSpecifiedMonthForUser($date, $un) . "</td>
                </tr>";
        }
        $sisters = $mysql->getAllActiveSisters();
        while($sisterInfo = mysqli_fetch_array($sisters)) {
            if(!in_array($sisterInfo[0], $passingSisters)) {
                echo "<tr>
                    <td>" . $mysql->getFullName($sisterInfo[0]) . "</td>
                    <td>" . $mysql->getPointsInSpecifiedMonthForUser($date, $sisterInfo[0]) . "</td>
                </tr>";
            }
        }
    ?>
</table>