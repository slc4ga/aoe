        
<?
    require_once('../nav/mysql.php');
    //session_start();

    $mysql = new Mysql();


    $userPoints = $mysql->getPointsInMonthForUser($_SESSION['user_id']);
    $monthPoints = $mysql->getPointsInMonth();
    echo "<h4 id='monthly-points'>" . date('F', time()) . " points: " . $userPoints . "/" . $monthPoints . "</h4>";
?>