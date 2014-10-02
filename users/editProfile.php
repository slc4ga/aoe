<?

    require_once '../nav/mysql.php';
    require_once '../nav/constants.php';
    
    $mysql = new Mysql();
                                            
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    
    $row = $mysql->getInfo($_SESSION['user_id'])->fetch_array(MYSQLI_NUM);

?>
<div class="col-md-11">
    <h2> Edit Profile </h2>
    <p>
        Fill out the form below to edit your profile.
    </p>
    <hr>
        <div class="row">
            <div class="col-md-5">
                <?
                    $imgPath="../img/" . $_SESSION['user_id'] . ".jpg";
                    echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                    height: 300px; width: 250px\">";
                    if(file_exists($imgPath)) {
                        echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                    } else {
                        echo "<br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                    }
                    echo "</div>";
                ?>
            </div>
            <div class="col-md-6" style="margin-left: -40px">
                <form action="picUpload.php" method="post" enctype="multipart/form-data" >
                     <label> Please specify a picture file: </label>
                     <input type="file" name="file" id="file"><br><br>
                     <input type="submit" name="picUpload" class="btn btn-success" value="Upload">
                </form>
            </div>
        </div>
        <br>
        <form action="submitEdits.php" class="form-inline" method="post" >
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Pledge Class: </b></span>
                    <? echo $row[3]; ?>
                <br><br>
                <span style="font-size:1.25em"><b> Year: </b></span> 
                <input type="number" name="year" class = "form-control" style="width: 50%" min="2014" max="2040" 
                       <? 
                            if(isset($row[4])) {
                                echo "value=\"$row[4]\""; 
                            } else {
                                echo "placeholder=\"2017\"";
                            }
                       ?> />
                <br><br>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Hometown: </b></span> <br>
                <div class="row">
                    <div class="col-md-12">
                        <input type="radio" id="us" name="loc" value="us" checked/> US &nbsp; &nbsp;
                        <input type="radio" id="international" name="loc" value="international"/> International <br><br>
                    </div>
                    <div id="hometown" class="col-md-12">
                        <input type="text" name="hometown" class="form-control" style="width: 100%"
                        <? 
                            if(isset($row[5]) && isset($row[6])) {
                                echo "value=\"$row[5]\""; 
                            } else {
                                echo "placeholder=\"Hometown\"";
                            }
                        ?> />
                        <div id="dropdown" style="margin-top: 8px;">
                            <?
                                include 'states.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
            <? echo $row[7]; ?>
        <div class="row">
            <div class="col-md-3">
                <span style="font-size:1.25em" ><b> Major: </b></span><br>
                <input type="radio" id="major" name="major" value="Aerospace Engineering" 
                       <? if($row[7] == "Aerospace Engineering") { echo "checked"; } ?> /> Aerospace <br>
                <input type="radio" id="major" name="major" value="Chemical Engineering"
                       <? if($row[7] == "Chemical Engineering") { echo "checked"; } ?> /> Chemical <br>
                <input type="radio" id="major" name="major" value="Computer Engineering" 
                       <? if($row[7] == "Computer Engineering") { echo "checked"; } ?> /> Computer <br>
                <input type="radio" id="major" name="major" value="Electrical Engineering"
                       <? if($row[7] == "Electrical Engineering") { echo "checked"; } ?> /> Electrical <br>
                <input type="radio" id="major" name="major" value="Mechanical Engineering"
                       <? if($row[7] == "Mechanical Engineering") { echo "checked"; } ?> /> Mechanical <br>
                <input type="radio" id="major" name="major" value="Biology"
                       <? if($row[7] == "Biology") { echo "checked"; } ?> /> Biology <br>
            </div>
            <div class="col-md-3">
                <br>
                <input type="radio" id="major" name="major" value="Biomedical Engineering" 
                       <? if($row[7] == "Biomedical Engineering") { echo "checked"; } ?> /> Biomedical <br>
                <input type="radio" id="major" name="major" value="Civil Engineering"
                       <? if($row[7] == "Civil Engineering") { echo "checked"; } ?> /> Civil <br>
                <input type="radio" id="major" name="major" value="Computer Science" 
                       <? if($row[7] == "Computer Science") { echo "checked"; } ?> /> Computer Science <br>
                <input type="radio" id="major" name="major" value="Engineering Science"
                       <? if($row[7] == "Engineering Science") { echo "checked"; } ?> /> Engineering Science <br>
                <input type="radio" id="major" name="major" value="Systems Engineering"
                       <? if($row[7] == "Systems Engineering") { echo "checked"; } ?> /> Systems <br>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Second Major: </b></span>
                <input type="text" id="major2" name="major2" class="form-control" style="width: 70%"                     
                        <? 
                            if(!isset($row[7])) { 
                                echo "disabled"; 
                            } else {
                                if(isset($row[8])) {
                                    echo "value=\"$row[8]\""; 
                                } else {
                                    echo "placeholder=\"Second Major\"";
                                }
                            }
                        ?> />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Minor: </b></span> 
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="minor" name="minor" class="form-control" style="width: 70%"                     
                            <? 
                                if(isset($row[9]) && strlen($row[9]) > 0) {
                                    echo "value=\"$row[9]\""; 
                                } else {
                                    echo "placeholder=\"Minor\"";
                                }
                            ?> />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Second Minor: </b></span> 
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="minor2" name="minor2" class="form-control" style="width: 70%"                     
                            <? 
                                if(!isset($row[9]) || strlen($row[9]) < 1) { 
                                    echo "disabled"; 
                                } else {
                                    if(isset($row[10])) {
                                        echo "value=\"$row[10]\""; 
                                    } else {
                                        echo "placeholder=\"Second Minor\"";
                                    }
                                }
                            ?> />
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em"><b> Activities: </b></span> <br>
                <em>Please enter one activity per line.</em>
                <textarea name="activities" id="activities" class="form-control" rows="6"><? 
                            $array = explode("\n", $row[11]);
                            if(count($array) - 1 > 0) {
                                for($i = 0; $i < count($array); ++$i) {
                                    echo $array[$i];
                                }
                            }
                        ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em"><b> Bio: </b></span>
                <textarea name="bio" id="bio" class="form-control" rows="6"><? echo trim($row[12]); ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <input type='submit' class="btn btn-lg btn-success" type="submit" value="Submit Changes" />
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">

    $(function(){
        $("#us, #international").change(function(){
            if($("#international").is(":checked")){
                $.ajax({
                    url: 'countries.php',
                    success: function(data){
                        $("#dropdown").html(data);
                    }
                });
            } else if($("#us").is(":checked")){
                $.ajax({
                    url: 'states.php',
                    success: function(data){
                        $("#dropdown").html(data);
                    }
                });
            }
        });
    });
    
    $( "#minor" ).keyup(function(){
        if( $( "#minor" ).val().length > 0) {
            $( "#minor2" ).prop('disabled', false);
            $( "#minor2" ).attr("placeholder", "Second Minor");
        } else {
            $( "#minor2" ).prop('disabled', true);
            $( "#minor2" ).attr("placeholder", "");
        }
    });
    
    $( "input[name='major']" ).change(function(){
        if (!$("input[name='major']:checked").val()) {
           $( "#major2" ).prop('disabled', true);
        }
        else {
            $( "#major2" ).prop('disabled', false);
            $( "#major2" ).attr("placeholder", "Second Major");
        } 
    });
    
    

</script> 
        