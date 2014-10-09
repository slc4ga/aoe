        
<?
    require_once('../nav/mysql.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    echo $mysql->getPointsInCategoryForUser('9') . '/' . $mysql->getPointsInCategory('9')
?>