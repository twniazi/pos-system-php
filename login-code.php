<?php 
require 'config/function.php';

if(isset($_POST['loginBtn'])){

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if($email != '' && $password != ''){

        // ✅ JOIN ADDED
        $query = "SELECT admins.*, roles.name AS role_name 
                  FROM admins 
                  JOIN roles ON admins.role_id = roles.id 
                  WHERE email='$email' 
                  LIMIT 1";

        $result = mysqli_query($conn,$query);

        if($result){

            if(mysqli_num_rows($result) == 1){

                $row = mysqli_fetch_assoc($result);

                if(!password_verify($password,$row['password'])){
                    redirect('login.php','Invalid password');
                }

                if($row['is_ban'] == 1){
                    redirect('login.php','Your account has been banned');
                }

                $_SESSION['loggedIn'] = true;

                // ✅ UPDATED SESSION
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role_id' => $row['role_id'],
                    'role_name' => $row['role_name'] // 🔥 NEW
                ];

                redirect('admin/index.php','Logged in successfully.');

            }else{
                redirect('login.php','Invalid email');
            }

        }else{
            redirect('login.php','Something went wrong');
        }

    }else{
        redirect('login.php','All fields are mandatory');
    }
}
?>