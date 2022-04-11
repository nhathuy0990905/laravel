<form method="POST" action="<?php echo route('categories.add')?>">
    <legend>Add Category</legend>
    <div class="form-group">
        <label for="">Add</label>
        <input type="text" class="form-control" id="" placeholder="Nhập chuyên mục...">
    </div>
    <?php echo csrf_field();?>
    <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    <button type="submit" class="btn btn-primary">Thêm chuyên mục</button>
</form>
