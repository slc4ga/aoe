<?
    require_once('../nav/mysql.php');
echo "here";
    require_once('../nav/constants.php');
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

echo "here";

    $date = $_GET['date'];
    $name = "Chapter";
    $late = "Late Chapter";
    $points = CHAPTER_POINTS;
    $category = 9;

echo "here";

    $mysql->addEvent($name, $date, $points, $category);
    echo "1";
    $mysql->addEvent($late, $date, $points/2, $category);
echo "2";
    $mysql->setChapterPass($mysql->generateChapterPassword());
echo "3";
    
    echo '<div class="panel-body">';
        include 'chapterForm.php';
        echo "<br>";
        $chaps = $mysql->getChapters();
        if($chaps->num_rows == 0) {
            echo "<p style='text-align:center'><em>No chapters entered yet!</em></p>";   
        } else {
            while ($chapter = mysqli_fetch_array($chaps)) {
                echo "<div class='col-md-4 chapter'>";
                    echo date('n/j/Y', $chapter[0]) . " ($chapter[1])";
                echo "</div>";
                $chapter = mysqli_fetch_array($chaps)
            }
        }
    echo '</div>';

?>