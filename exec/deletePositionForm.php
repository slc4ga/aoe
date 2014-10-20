<form action="deletePosition.php" method="get" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-12">
            <select class="form-control" id="name" name="name" style="margin-bottom: 15px;">
                <option disabled selected>Choose Position to Delete</option>
                <?
                    $positions = $mysql->getPositions();
                    while($pos = mysqli_fetch_array($positions)) {
                        echo "<option value='$pos[0]'>$pos[1]</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="btn btn-danger" style="width: 100%;" 
                   type="submit" value="Delete Leadership Position" />
        </div>
    </div>
    <br>
</form>