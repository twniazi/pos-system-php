<?php include('includes/header.php');?>

<div class="container-fluid px-4">
<div class="card mt-4 shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Products</h4>
        <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
    </div>
    <div class="card-body">
        <?php 
    alertMessage();
    ?>
      <?php 
                    $products=getAll('products');
                    if(!$products){
                        echo '<h4>Something went wrong!.</h4>';
                        return false;
                    }
                    if(mysqli_num_rows($products)>0){

                     
      ?>
        <div class="table-responsive">
            <div class="table table-striped table-bordered ">
                <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>NAME</th>
                        <th>Status</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                  
                    <?php
                    foreach($products as $item): ?>
                    <tr>
                        <td><?=$item['id']?></td>
                        <td><img src="../<?=$item['image'];?>" style="width:50px;height:50px;"></td>
                        <td><?=$item['name']?></td>
                        <td>
                            <?php
                            if($item['status']==1){
                                echo '<span class="badge bg-danger">Hidden</span>';
                            }else{
                                echo '<span class="badge bg-primary">Visible</span>';
                            }

                            ?>          
                        </td>
                        <td>
                           <a href="products-edit.php?id=?<?=$item['id'];?>" class="btn btn-success btn-sm">Edit</a>
                           <a href="products-delete.php?id=?<?=$item['id'];?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delte this image')"
                           >Delete</a>
                        </td>
                    </tr>
                   <?php endforeach; ?>

                   
                </tbody>
                    </table>
            </div>
             <?php 
                     }
                    else{
                        ?>
                          <tr>
                        <h4 class="mb-0">No Record Found</h4>
                        
                        </tr>
                        <?php 
                        
                       
                      }
                    ?>
        </div>
    </div>
</div>
</div>
<?php include('includes/footer.php');?>