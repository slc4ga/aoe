<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();

    $class = $_GET['class'];

    $exec = $mysql->getExec();
    $chairs = $mysql->getPositions();

    if($class == 'exec') {
        echo '<div class="row">
                <div class="col-md-11">
                    <h2> 
                        <p class="text-center"> 
                            Exec Board Members 
                        </p>
                    </h2>
                    <hr>
                </div>
            </div>';
        echo '<div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-striped" id="listTable">';
                            while ($row = mysqli_fetch_array($exec,MYSQL_BOTH)){
                                echo "<tr><th>". $row[1] . "</th>";
                                echo "<td>";
                                    echo "<div id=\"sisters" . $row[0] . "\">";
                                        $pos = $mysql->getAllLeaders($row[0]);
                                        while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
                                            echo "<a href=\"../sisters/sisters.php?select=$row2[0]\">" . 
                                                $mysql->getFullName($row2[0]) . "</a><br>"; 
                                        }
                                    echo "</div>";
                                echo "</td>";
                            }			
                echo '</table>
                    <script type="text/javascript">  
                        function profile(id) {
                            $.ajax({
                                url: \'sisProf.php\',
                                data: { id:id },
                                success: function(data){
                                    $(\'#content\').html(data);   
                                }
                            });
                            return false;
                        };  
                    </script>
                </div>';
    } else if($class == 'chairs') {
        echo '<div class="row">
                <div class="col-md-11">
                    <h2><p class="text-center"> 
                         Chair Positions 
                    </p></h2>
                    <hr>
                </div>
            </div>';
        echo'<div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-striped" id="listTable">';
                            while ($row = mysqli_fetch_array($chairs,MYSQL_BOTH)){
                                echo "<tr><th>". $row[1] . "</th>";
                                echo "<td>";
                                    echo "<div id=\"sisters" . $row[0] . "\">";
                                        $pos = $mysql->getAllLeaders($row[0]);
                                        while ($row2 = mysqli_fetch_array($pos,MYSQL_BOTH)){
                                            echo "<a href=\"../sisters/sisters.php?select=$row2[0]\">" .
                                                $mysql->getFullName($row2[0]) . "</a><br>"; 
                                        }
                                    echo "</div>";
                                echo "</td>";
                            }			
                echo '</table>
                    <script type="text/javascript">  
                        function profile(id) {
                            $.ajax({
                                url: \'sisProf.php\',
                                data: { id:id },
                                success: function(data){
                                    $(\'#content\').html(data);   
                                }
                            });
                            return false;
                        };  
                    </script>
                </div>'; 
    }