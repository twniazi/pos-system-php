<?php  
require '../config/function.php';


$paraResultId=checkParamId('id');
if(is_numeric($paraResultId)){
    $categoryId =validate($paraResultId);
    $category=getById('categories',$categoryId);
    if($acategory['status']==200){
    $response=delete('categories',$categoryId);
    if($response){
 redirect('categories.php','category deleted successfully.');
    }else{
         redirect('categories.php','something went wrong');
    }

    }else{
        redirect('categories.php',$category['message']);
    }
}else{
    redirect('categories.php','something went wrong');
}
 

?>