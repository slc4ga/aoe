        
<?
    require_once('../nav/mysql.php');
    //session_start();

    $mysql = new Mysql();

    echo $mysql->getPointsInCategoryForUser('9') . '/' . $mysql->getPointsInCategory('9')
?>