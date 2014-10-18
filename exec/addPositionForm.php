<form action="addPosition.php" method="get" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-4">
            <input class="form-control" id="name" style="margin-bottom: 15px;" type="text" name="name"  
                size="50" placeholder="Position Name"/>
        </div>
        <div class="col-md-4">
            <select class="form-control" id="order" name="order">
                <option disabled selected>Choose Position Type</option>
                <option value="0">Chair</option>
                <option value="-1">Committee</option>
                <option value="1">Exec</option>
            </select>
        </div>
        <div class="col-md-4">
            <input class="btn btn-primary" style="width: 100%;" 
                   type="submit" value="Add Leadership Position" />
        </div>
    </div>
    <br>
</form>