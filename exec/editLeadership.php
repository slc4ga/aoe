<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();

    $exec = $mysql->getExec();
    $chairs = $mysql->getPositions();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }

?>

<script type="text/javascript">
    <?
        $tags = "";
        $sisters = $mysql->getAllActiveSisters();
        while ($row2 = mysqli_fetch_array($sisters,MYSQL_BOTH)){
            $tags .= "\"" . $row2[1] . " " . $row2[2] . "\",";
        }
        $escaped_value = str_replace(chr(13),'',substr($tags, 0, -1));
        $escaped_value = str_replace(chr(10),'',$escaped_value);

        echo 'var availableTags = [' . $escaped_value . '];';
    ?>
</script>

<div id="userlisthome" class='col-md-12'>
	<div id='userslist'>
        <h2> Manage Leadership Positions </h2>
        <p>
            <em> Use the search bars below to change who currently holds leadership positions within A&Omega;E Pi.</em>
        </p>
        <br>
        <hr>
        <div id="posResult"></div>
        <?
            include 'addPositionForm.php';
        ?>
        <hr>
		<h3>Exec Board</h3>
		<table class='table' id="execListTable">
			<?php

				while ($row = mysqli_fetch_array($exec,MYSQL_BOTH)){
					echo "<tr><th>". $row[1] . "</th>";
                    echo "<td>";
                        echo "<div id=\"sisters" . $row[0] . "\">";
                            $pos = $mysql->getAllLeaders($row[0]);
                            while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
                                echo $mysql->getFullName($row2[0]); 
                                echo "  <a onclick=\"deleteLeader('" . $row[0] . "','" . $mysql->getFullName($row2[0]) . "')\"><span class=\"glyphicon glyphicon-remove\"></span></a><br>";
                            }
                        echo "</div>";
                    echo "</td>";
                    echo"<td><form class=\"form-inline\">
                        <input type=\"text\" class=\"search form-control\" id=\"searchid" . $row[0] . 
                            "\" style=\"width: 80%\" placeholder=\"Search for Sisters\" />
                        <a id=\"add" . $row[0] . "\" onclick=\"addLeader('" . $row[0] . "')\" 
                            class=\"btn btn-lg\"><span class=\"glyphicon glyphicon-ok\"></span></a>
                        </form>
                        </td></tr>";
                    echo '<script type="text/javascript">
                          $(function() {
                            $( "#searchid' . $row[0] . '" ).autocomplete({
                              source: availableTags
                            });
                          });
                    </script>';
				}			
			?>
		</table>
        <br>
        <hr>
        <h3>Chair Positions</h3>
		<table class='table' id="chairListTable">
			<?php

				while ($row = mysqli_fetch_array($chairs,MYSQL_BOTH)){
					echo "<tr><th>". $row[1] . "</th>";
                    echo "<td>";
                        echo "<div id=\"sisters" . $row[0] . "\">";
                            $pos = $mysql->getAllLeaders($row[0]);
                            while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
                                echo $mysql->getFullName($row2[0]);  
                                echo "  <a onclick=\"deleteLeader('" . $row[0] . "','" . $mysql->getFullName($row2[0]) . "')\"><span class=\"glyphicon glyphicon-remove\"></span></a><br>";
                            }
                        echo "</div>";
                    echo "</td>";
                    echo"<td><form class=\"form-inline\">
                        <input type=\"text\" class=\"search form-control\" id=\"searchid" . $row[0] . 
                            "\" style=\"width: 80%\" placeholder=\"Search for Sisters\" />
                        <a onclick=\"addLeader('" . $row[0] . "')\" id=\"add" . $row[0] . "\"  
                            class=\"btn btn-lg\"><span class=\"glyphicon glyphicon-ok\"></span></a>
                        </form>
                        </td></tr>";
                    echo '<script type="text/javascript">
                          $(function() {
                            $( "#searchid' . $row[0] . '" ).autocomplete({
                              source: availableTags
                            });
                          });
                    </script>';
				}			
			?>
		</table>
	</div>
</div>
<script type="text/javascript">  
    if(pos === 'added') {
        $('#posResult').html(
          "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span> </button> <strong>Nice!</strong> Your leadership position was added.</div>"  
        );
    }
    
    function addLeader(position) {
        var id1 = "searchid" + position;
        var id2 = "sisters" + position;
        var curSister = document.getElementById(id1).value;
        var sisters = document.getElementById(id2);
        //alert(position);
        //alert(curSister);
        var newHTML = sisters.innerHTML + curSister + "  <a onclick=\"deleteLeader('" + position + "','" + curSister + "')\"><span class=\"glyphicon glyphicon-remove\"></span></a><br>";
        if(availableTags.indexOf(curSister) > -1) {
            $.ajax({
                url: 'addLeader.php',
                data: { pos:position, sister:curSister },
                success: function(data){
                   // alert(data);
                    sisters.innerHTML = newHTML;  
                    document.getElementById(id1).value = "";
                }
            });
        }
        else {
            bootbox.dialog({
                message: "Looks like that sister doesn't exist yet...try again!",
                title: "Uh-oh!",
                buttons: {
                    danger: {
                        label: "Ok",
                        className: "btn-danger",
                    }
                }
            });
        }
        return false;
    };  
    
    function deleteLeader(position, sister) {
        var id2 = "sisters" + position;
        var sisters = document.getElementById(id2);
        
        var res = sisters.innerHTML.split("<br>");
        var newHTML = "";
        for (var i=0; i < res.length-1; i++) { 
            if(res[i].indexOf(sister) == -1) {
                newHTML += res[i] + "<br>";    
            }
        }
        $.ajax({
                url: "deleteLeader.php",
                data: { pos: position, 
                        sister: sister },
                success:function() {
                    sisters.innerHTML = newHTML;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
    };  
</script>