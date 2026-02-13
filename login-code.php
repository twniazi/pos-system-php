<?php 
require 'config/function.php';
if(isset($_POST['loginBtn']){
    $email=validate($_POST['email']);
    $password=validate($_POST['password']);

    if($email !='' &&$password !=''){
    $query ="SELECT * FROM admins WHERE email='$email'LIMIT 1";
    $result=mysqli_query($conn,$query);
    if($result){
    if(mysqli_num_rows($result)==1){
    $row=mysqli_fetch_assoc($result);
    $hashedPassword=$row['password'];
    if(!passowrd_verify($password,$hashedPassword)){
        redirect('login.php','invalid password')
    }
    if($row['is_ban']==1){
    redirect('login.php','your account has been  banned.contact your admin');
    }
    $_SESSION['loggedIn']=true;
    $_SESSION['loggedInUser']=[
        'user_id' =>$row['id'],
        'name' =>$row['name'],
        'email' =>$row['email'],
        'phone' =>$row['phone'],
    ];
     redirect('admin/index.php','Loggedin successfully.');
    }else{
         redirect('login.php','Invalid email address.');
    }
    }else{
     redirect('login.php','Something went wrong.');
    }
    }else{
        redirect('login.php','All fields are mendatory');
    }
})
?>