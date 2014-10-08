<?
    require_once('../nav/mysql.php');
    require_once('../nav/constants.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $date = $_GET['date'];
    $name = "Chapter";
    $points = CHAPTER_POINTS;
    $category = 9;

    $mysql->addEvent($name, $date, $points, $category);
    $mysql->setChapterPass($mysql->generateChapterPassword());
    
    echo '<div class="panel-body">';
        include 'chapterForm.php';
        echo "<br>";
        $chaps = $mysql->getChapters();
        if($chaps->num_rows == 0) {
            echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
        } else {
            while ($chapter = mysqli_fetch_array($chaps)) {
                echo "<div class='col-md-4 chapter'>";
                    echo date('n/j/Y', strtotime($chapter[3])) . " ($chapter[6])";
                echo "</div>";

            }
        }
    echo '</div>';

?>