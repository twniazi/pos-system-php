<?php 
include('includes/header.php'); 
?>

<div class="container-fluid px-4">
<div class="card mt-4 shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Create Order</h4>
        <a href="orders.php" class="btn btn-primary float-end">Back</a>
    </div>
    <div class="card-body">
        <?php alertMessage(); ?>

        <!-- Form to add product item to session -->
        <form action="orders-code.php" method="POST">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="">Select Product</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">--Select Product--</option>
                        <?php
                        $products = getAll('products');
                        if($products && mysqli_num_rows($products) > 0){
                            foreach($products as $prodItem){
                                echo "<option value='{$prodItem['id']}'>{$prodItem['name']}</option>";
                            }
                        } else {
                            echo "<option value=''>No product found.</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="">Quantity</label>
                    <input type="number" name="quantity" value="1" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3 text-end">
                    <br>
                    <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- Display session products -->
<?php if(isset($_SESSION['productItems']) && !empty($_SESSION['productItems'])): 
    $sessionProducts = $_SESSION['productItems'];
?>
<div class="card mt-3">
    <div class="card-header">
        <h4 class="mb-0">Products</h4>
    </div>
    <div class="card-body">
        <form action="orders-code.php" method="POST">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($sessionProducts as $key=>$item): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['price']; ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $item['product_id']; ?>]" value="<?= $item['quantity']; ?>" class="form-control">
                        </td>
                        <td><?= number_format($item['price']*$item['quantity'],0); ?></td>
                        <td>
                            <a href="orders-code.php?remove=<?= $item['product_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="">Payment Mode</label>
                    <select name="payment_mode" class="form-select" required>
                        <option value="">Select payment</option>
                        <option value="Cash Payment">Cash Payment</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Customer Phone</label>
                    <input type="number" name="customer_phone" class="form-control" value="" required>
                </div>
                <div class="col-md-4">
                    <br>
                    <button type="submit" name="placeOrder" class="btn btn-warning w-100">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>