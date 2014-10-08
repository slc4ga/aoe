<div class="row">
    <div class="col-md-4 col-md-offset-2">
        <input class="form-control" id="chapterDate" style="margin-bottom: 15px;" type="date" name="chapterDate" 
               size="50" value="<? echo date('Y-m-d', time()); ?>"/>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary" style="width: 100%;" 
                id="addChapter" name="addChapter" onclick="addChapter()">Add Chapter</button>
    </div>
</div>