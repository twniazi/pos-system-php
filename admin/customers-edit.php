<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer</h4>
            <a href="customers.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php 
            // Correct function name
            $parmValue = checkParamId('id');

            if(!is_numeric($parmValue)){
                echo '<h5>' . $parmValue . '</h5>';
                return false;
            }

            $customer = getById('customers', $parmValue);

            // Corrected condition: status==200 means success
            if(isset($customer['status']) && $customer['status'] == 200){
                $data = $customer['data'];
            ?>
                <form action="code.php" method="POST">
                    <input type="hidden" name="customerId" value="<?= $data['id']; ?>">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" value="<?= $data['name']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Email Id</label>
                            <input type="email" name="email" value="<?= $data['email']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Phone</label>
                            <input type="number" name="phone" value="<?= $data['phone']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status </label><br>
                            <input type="checkbox" name="status" <?= $data['status'] == 1 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        </div>

                        <div class="col-md-6 mb-3 text-end">
                            <br>
                            <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            <?php 
            } else {
                // Show error if customer not found
                echo '<h5>'.$customer['message'].'</h5>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>