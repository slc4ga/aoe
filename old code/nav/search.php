<?

    include "mysql.php";
    $mysql = New Mysql();
    
    $terms = $_GET['term'];
    
    echo "<h2> Search Results </h2><hr>";
    echo "<table><tbody>";
    $result2 = $mysql->searchPledgeClass($terms);

    while ($row = mysqli_fetch_array($result2)) {
        echo "<tr>";
        if ($row[0] == 'Kappa') { $num = 1; }
        else if ($row[0] == 'Lambda') { $num = 2; }
        else if ($row[0] == 'Mu') { $num = 3; }
        else { $num = 4; }
        echo "<h4><a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=" . $num . "\">" . 
            $row[0] . " Pledge Class</a></h4>";
        echo "<p style=\"margin-top: -10px; margin-bottom: 20px\">A list of all members in the " . $row[0] . " pledge class</p>";
        echo "</tr>";
    }
    $result6 = $mysql->searchExecPositions($terms);
    while ($row = mysqli_fetch_array($result6)) {
        echo "<tr>";
        echo "<h4><a href=\"http://alphaomegaepsilonatuva.com/public/leadership.php?select=1\">" . $row[1] . "</a></h4>";
        echo "<p style=\"margin-top: -10px; margin-bottom: 20px\">For A&Omega;E at UVa, ";
        $pos = $mysql->getAllLeaders($row[2]);
        $str = "";
        while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
            $str1 = "<a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=$row2[0]\">" . 
                $mysql->getFullName($row2[0]) . "</a>, "; 
            $name = $row2[0];
            $str .= $str1;
        }
        $str = substr($str, 0, strlen($str) - strlen($str1));
        if ($pos->num_rows > 1) { $str .= " and "; } 
        $str .= " <a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=$name\">" . 
                $mysql->getFullName($name) . "</a>";
        echo $str;
        if ($pos->num_rows > 1) { echo " serve "; } else { echo " serves "; }
        echo "as " . $row[1] . "</p>";
        echo "</tr>";
    }
    $result3 = $mysql->searchChairPositions($terms);
    while ($row = mysqli_fetch_array($result3)) {
        echo "<tr>";
        echo "<h4><a href=\"http://alphaomegaepsilonatuva.com/public/leadership.php?select=2\">" . $row[1] . "</a></h4>";
        echo "<p style=\"margin-top: -10px; margin-bottom: 20px\">For A&Omega;E at UVa, ";
        $pos = $mysql->getAllLeaders($row[2]);
        $str = "";
        while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
            $str1 = "<a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=$row2[0]\">" . 
                $mysql->getFullName($row2[0]) . "</a>, "; 
            $name = $row2[0];
            $str .= $str1;
        }
        $str = substr($str, 0, strlen($str) - strlen($str1));
        if ($pos->num_rows > 1) { $str .= " and "; } 
        $str .= " <a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=$name\">" . 
                $mysql->getFullName($name) . "</a>";
        echo $str;
        if ($pos->num_rows > 1) { echo " serve "; } else { echo " serves "; }
        echo "as " . $row[1] . "</p>";
        echo "</tr>";
    }
    $result1 = $mysql->searchSisters($terms);
    while ($row = mysqli_fetch_array($result1)) {
        echo "<tr>";
        echo "<h4><a href=\"http://alphaomegaepsilonatuva.com/sisters/sisters.php?select=" . $row[0] . "\">" . 
            $mysql->getFullName($row[0]) . "</a></h4>";
        echo "<p style=\"margin-top: -10px; margin-bottom: 20px\">" . $mysql->getFullName($row[0]) . "'s sister profile</p>";
        echo "</tr>";
    }
   //somehow search html?
   echo "</tbody></table>";

?>