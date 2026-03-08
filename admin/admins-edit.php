<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin</h4>
            <a href="admins.php" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php 
            // Validate GET id
            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $adminId = validate($_GET['id']);
            } else {
                echo '<h5>No valid ID provided.</h5>';
                return false;
            }

            // Fetch admin data
            $adminData = getById('admins', $adminId);

            if(isset($adminData['status']) && $adminData['status'] == 200){
                $data = $adminData['data'];
            ?>
                <form action="code.php" method="POST">
                    <input type="hidden" name="adminId" value="<?= $data['id']; ?>">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Name *</label>
                            <input type="text" name="name" value="<?= $data['name']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Email *</label>
                            <input type="email" name="email" value="<?= $data['email']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Password</label>
                            <input type="password" name="password" placeholder="Leave blank to keep current password" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Phone Number</label>
                            <input type="number" name="phone" value="<?= $data['phone']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="">Is Ban</label><br>
                            <input type="checkbox" name="is_ban" <?= $data['is_ban'] == 1 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        </div>

                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            <?php 
            } else {
                echo '<h5>' . ($adminData['message'] ?? 'Admin not found.') . '</h5>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>