<?php
	include_once('../nav/mysql.php');
	session_start();
	$mysql = new Mysql();
	$lists = $mysql->getClassCount();

    if(!isset($_SESSION['user_id']) || $mysql->checkExec($_SESSION['user_id']) < 1) {
        header("location:../index.php");
    }
?>

<div id="userlisthome" class='col-md-11'>
	<div id='userslist'>
		<h2>Existing Pledge Classes</h2>
		<table class='table' id="classListTable">
			<tr>
				<th>Pledge Class</th>
				<th>No. of Members</th>
				<th>Convert to Alum?</th>
			<tr>
			<?php
                echo "<tr><td><a href='#classtable' id='Alumnae'>". Alumnae . "</a></td><td>" . $mysql->getClassNums('Alumnae')
                    . "</td><td>";
				while ($row = mysqli_fetch_array($lists,MYSQL_BOTH)){
					echo "<tr><td><a href='#classtable' id='$row[0]'>". $row[0] . "</a></td><td>" . $row[1] . "</td><td>";
                    if($row[0] != 'Alumnae')
                        echo "<button type='button' onClick=\"convertClass('" . $row[0] . "')\" id='$row[0]' 
                            class='convert btn btn-sm'>Convert</button></td></tr>";
				}			
			?>
		</table>
	</div>
	<div id='classmembers'>
		<h3 id='classheader'></h3>
		<div id ='classtable'>
		</div>
	</div>
    <div id="accordion2" class="acc" style="display:none">
        <h4>Add Sister</h4>
        <div>
            <form class="form-inline">
                <input type="text" style="width: 30%" class="form-control" placeholder="Computing ID" id="sisterID" />
                <input type="text" style="width: 30%" class="form-control" placeholder="First Last" id="sisterName" />
                <br>
                <button type='button' onClick="addSister()" class='btn btn-success' style="margin-top: 10px;">Submit</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    
        function addSister() {   
            var name = document.getElementById("sisterName").value;
            var id = document.getElementById("sisterID").value;
            var pc = document.getElementById("classheader").innerHTML ;
            if(pc != ""){
                $.ajax({
                    url: 'addSister.php',
                    data: {id: id, name: name, pc: pc},
                    success: function(data){
                        $("#classtable").html(data);
                        var table = document.getElementById('classListTable');
                        for (var r = 0, n = table.rows.length; r < n; r++) {
                            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
                                if(table.rows[r].cells[c].innerHTML.indexOf(pc) != -1 && c < (table.rows[r].cells.length-1)) {
                                   table.rows[r].cells[c+1].innerHTML = (parseFloat(table.rows[r].cells[c+1].innerHTML) + 1);
                                }
                            }
                        }
                        document.getElementById("sisterID").value = '';
                        document.getElementById("sisterName").value = '';

                    },
                    error: function(xhr, status, error) {
                        console.log(status + " " + error);
                    }
                });
            }
        };
    
        function convertClass(id){
            document.getElementById("classheader").innerHTML="";  
            $.ajax({
                url: 'convertClass.php',
                data: {class: id},
                success: function(data){
                    window.location.href = "webmaster.php?select=2";
                }
            });
        };

        $(document).ready(function(){

        	var classID = '';
            
            $('table').delegate("a", "click", (function(){
               classID = $(this).attr('id');
               var e = document.getElementById("classheader");
               e.innerHTML=$(this).text();
               document.getElementById('accordion2').style.display= 'block' ;
               $.ajax({
                        url: 'classMembers.php',
                        data: {class: classID},
                        success: function(data){
                            $("#classtable").html(data);
                        }
                });
            }));
            
        }); 

</script>