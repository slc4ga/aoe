<form action="addEvent.php" method="post" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-6">
            <input class="form-control" id="name" style="margin-bottom: 15px;" type="text" name="name"  
                size="50" placeholder="Event Name"/>
            <select class="form-control" style="margin-bottom: 15px;" id="category" name="category">
                <option selected disabled>Category</option>
                <?
                    $result = $mysql->getPointsCategories();
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value=$row[0]>$row[1]</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <input class="form-control" id="date" style="margin-bottom: 15px;" type="date" name="date" 
                   size="50" placeholder="Date"/>
            <input class="form-control" id="points" style="margin-bottom: 15px;" type="number" name="points" 
                   size="50" placeholder="Points"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="btn btn-primary" style="width: 100%;" 
                   type="submit" value="Add Event" />
        </div>
    </div>
    <br>
</form>