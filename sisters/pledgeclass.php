<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();

    $class = $_GET['class'];

    $num = $mysql->getClassNums($class);
    $count = 1;

    if($num == 0) {
        echo "<h4> There are no sisters currently listed in this pledge class. Check out another class to view sister profiles!</h4>";
    }
    else {

        echo "<table class=\"table table-hover\">  
                <thead>  
                <tr>  
                <th>#</th>
                <th>Name</th>  
                <th>Year</th>
                <th>Major</th>
                </tr>  
                </thead>  
                <tbody> ";
    
        
        $result = $mysql->getClassMembers($class);
        if (gettype($result) == "boolean") {
            echo "failed<br>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $count . "</td>";
                echo "<td><a onclick=\"profile('" . $row[0] . "')\">" . $row[1] . " " . $row[2] . "</a></td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "</tr>";
                $count++;
            }
        }
        echo "</tbody>  
        </table>";
    }

?>
<script type="text/javascript">  
    function profile(id) {
        $.ajax({
            url: 'sisProf.php',
            data: { id:id },
            success: function(data){
                $('#content').html(data);   
            }
        });
        return false;
    };  
    
</script>