<form action="addEventCategory.php" method="post" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-6">
            <input class="form-control" id="name" style="margin-bottom: 15px;" type="text" name="name"  
                size="50" placeholder="Category Name"/>
        </div>
        <div class="col-md-6">
            <select class="form-control" name="order" id="order">
                <option disabled selected>Mandatory Category?</option>
                <option value="0">Yes</option>
                <option value="-1">No</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="btn btn-primary" style="width: 100%;" 
                   type="submit" value="Add Event Category" />
        </div>
    </div>
    <br>
</form>