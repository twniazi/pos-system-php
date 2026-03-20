<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Category</h4>
            <a href="categories.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php 
                $parmValue = checkParamId('id');
                if(!is_numeric($parmValue)){
                    echo '<h5>' . $parmValue . '</h5>';
                    return false;
                }

                $category = getById('categories', $parmValue);

                if($category['status'] == 200){
                    $data = $category['data'];
            ?>

            <form action="code.php" method="POST">
                <input type="hidden" name="categoryId" value="<?= $data['id']; ?>">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" value="<?= $data['name']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= $data['description']; ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status </label>
                        <br>
                        <input type="checkbox" name="status" <?= $data['status'] == 1 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                    </div>

                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit"  name="updateCategory" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>

            <?php 
                } else {
                    echo '<h5>'.$category['message'].'</h5>';
                }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>