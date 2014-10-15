<form action="addAttendanceExemption.php" method="post" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <select class="form-control" style="margin-bottom: 15px;" id="sister" name="sister">
                <option disabled selected> Select Sister </option>
                <?
                    $sisters = $mysql->getAllActiveSisters();
                    while($sisterInfo = mysqli_fetch_array($sisters)) {
                        echo "<option value='$sisterInfo[0]'>$sisterInfo[1] $sisterInfo[2]</option>";    
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" style="margin-bottom: 15px;" id="date" name="date">
                <option disabled selected> Select Chapter Date </option>
                <?
                    $chapters = $mysql->getEventsInCategory(9); // get all chapters
                    while($chapterInfo = mysqli_fetch_array($chapters)) {
                        echo "<option value='$chapterInfo[0]'>$chapterInfo[1] - " . date('n/j/Y', strtotime($chapterInfo[3])) . "</option>"; 
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <input class="btn btn-primary" style="width: 100%" type="submit" value="Submit Attendance Exemption" />
        </div>
    </div>
    <br>
</form>