<?php 
include('includes/header.php'); 
require('../config/function.php'); // ensure DB connection
?>

<div class="container-fluid px-4">
<div class="card mt-4 shadow-sm">

    <div class="card-header">
        <h4 class="mb-0">Admins/Staff</h4>
        <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
    </div> 

    <div class="card-body">
        <?php alertMessage(); ?>

        <?php 
        // ✅ JOIN QUERY (IMPORTANT)
        $query = "SELECT admins.*, roles.name AS role_name 
                  FROM admins 
                  JOIN roles ON admins.role_id = roles.id";

        $admins = mysqli_query($conn,$query);

        if(!$admins){
            echo '<h4>Something went wrong!</h4>';
            return false;
        }

        if(mysqli_num_rows($admins) > 0){
        ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLE</th> <!-- 🔥 NEW -->
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($adminItem = mysqli_fetch_assoc($admins)): ?>
                    <tr>
                        <td><?= $adminItem['id'] ?></td>
                        <td><?= $adminItem['name'] ?></td>
                        <td><?= $adminItem['email'] ?></td>

                        <!-- ✅ ROLE SHOW -->
                        <td>
                            <?php 
                                if($adminItem['role_name'] == 'Super Admin'){
                                    echo '<span class="badge bg-danger">Super Admin</span>';
                                }elseif($adminItem['role_name'] == 'Admin'){
                                    echo '<span class="badge bg-primary">Admin</span>';
                                }else{
                                    echo '<span class="badge bg-secondary">User</span>';
                                }
                            ?>
                        </td>

                        <td>
                            <a href="admins-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>

                            <!-- 🔐 Prevent deleting Super Admin -->
                            <?php if($adminItem['role_id'] != 1): ?>
                                <a href="admins-delete.php?id=<?= $adminItem['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Protected</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>

        <?php 
        } else {
            echo '<h4 class="mb-0">No Record Found</h4>';
        }
        ?>

    </div>
</div>
</div>

<?php include('includes/footer.php'); ?>