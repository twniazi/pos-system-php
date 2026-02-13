<?php 
include('../config/function.php');

if(isset($_POST['saveAdmin']))
    {
        $name= validate($_POST['name']);
        $email= validate($_POST['email']);
        $password= validate($_POST['password']);
        $phone= validate($_POST['phone']);
        $is_ban= isset($_POST['is_ban']) == true ?1:0;

        if($name !='' && $email != '' && $password !=''){
            $emailCheck =mysqli_query($conn,"SELECT * from admins WHERE email='$email'");
            if($emailCheck){
                if(mysqli_num_rows($emailCheck) >0){
                    redirect('admins-create.php','Email Already used by another user.');
                    
                }
            }
            $bcrypt_password =password_hash($password,PASSWORD_BCRYPT);
           $data = [
   'name'      => $name,
   'email'     => $email,
   'password'  => $bcrypt_password,
   'phone'     => $phone,
   'is_ban'    => $is_ban
];

            $result=insert('admins',$data);
            if($result){
                redirect('admins.php','Admin created successfully!');
            }
            else{
                redirect('admins-create.php','Something went wrong!');
            }

        }else{
            redirect('admins-create.php','Please filled required fields.');
        }
    }

if(isset($_POST['updateAdmin']))
    {
        $adminId= validate($_POST['adminId']);
        $adminData=getById('admins',$adminId);
        if($adminData['status']!=200){
            redirect('admins-edit.php?id='.$adminId,'Please filled required fields.');
        }
         $name= validate($_POST['name']);
        $email= validate($_POST['email']);
        $password= validate($_POST['password']);
        $phone= validate($_POST['phone']);
        $is_ban= isset($_POST['is_ban']) == true ?1:0;

        $EmailCheckQuery ="SELECT * FROM admins WHERE email='$email' AND id!='$adminId'";
        $checkResult=mysqli_query($conn,$EmailCheckQuery);
        if($checkResult){
            if(mysqli_num_rows($checkResult)>0){
                redirect('admins-edit.php?id='.$adminId,'Email already used by another user');
            }
        }

        if($password !=''){
            $hashedPassword =password_hash($password,PASSWORD_BCRYPT);
        }else{
              $hashedPassword =$adminData['data']['password'];
        }

        if($name !='' && $email != ''){
            $data = [
   'name'      => $name,
   'email'     => $email,
   'password'  => $hashedPassword,
   'phone'     => $phone,
   'is_ban'    => $is_ban
];

            $result=update('admins',$adminId,$data);
            if($result){
                redirect('admins-edit.php?id='.$adminId,'Admin updated successfully!');
            }
            else{
                redirect('admins-create.php?id='.$adminId,'Something went wrong!');
            }

        }else{
            redirect('admins-create.php','Please filled required fields.');
        }
    }



    if(isset($_POST['saveCategory'])){
         $name= validate($_POST['name']);
        $description= validate($_POST['descryption']);
        $status= validate($_POST['status'])==true ?1:0;
         $data = [
   'name'      => $name,
   'descryption'     => $description,
   'status'    => $status
];

            $result=insert('categories',$data);
            if($result){
                redirect('categories.php','Category created successfully!');
            }
            else{
                redirect('categories-create.php?id=','Something went wrong!');
            }
    }

//update category
if(isset($_POST['updateCategory'])){
        $categoryId= validate($_POST['categoryId']);
        $description= validate($_POST['descryption']);
        $status= validate($_POST['status'])==true ?1:0;
         $data = [
   'name'      => $name,
   'descryption'     => $description,
   'status'    => $status
];

            $result=update('categories',$categoryId,$data);
            if($result){
                redirect('categories-edit.php?id='.$categoryId,'Category updated successfully!');
            }
            else{
                redirect('categories-edit.php?id='.$categoryId,'Something went wrong!');
            }
}
?>