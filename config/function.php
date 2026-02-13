<?php 

session_start();
require 'dbcon.php';

//input field validation
function validate($inputData){

    global $conn;
    $validatedData =mysqli_real_escape_string($conn,$inputData);
    return trim($validatedData);
}
//redirecting path
function redirect($url,$status)
{
    $_SESSION['status']=$status;
    header('location'.$url);
    exit(0);
}
//display messages or status after any process.
if (isset($_SESSION['status'])) {

    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h6>' . $_SESSION['status'] . '</h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

    unset($_SESSION['status']);
}


//insert record using this function
function insert($tableName,$data){
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);
    $finalColumn = implode(',',$columns);
    $finalValues = "'".implode("','",$values)."'";
    $query="INSERT INTO $table($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn,$query);
    return $result;
}

//update data using this function
function update($tableName,$id,$data){
    global $conn;
    $table = validate($tableName);
    $id= validate($id);
    $updateDataString ="";
    foreach($data  as $column =>$value)
        {
             $updateDataString .=$column.='='."'$value',";
        }
    $finalUpdateData =substr(trim($updateDataString),0,-1);
    $query="UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result=mysqli_query($con,$query);
    return $result;
}

//get all data
function getAll($tableName,$status= NULL)
{
    global $conn;
   $table = validate($tableName);
   $status = validate($status);

   if($status=='status')
    {
        $query="SELECT * from $table WHERE status ='0'";
    }
    else{
        $query="SELECT * from $table";
    }
    return mysqli_query($conn,$query);
}

function getById($tableName,$id)
{
    global $conn;
    $table = validate($tableName);
    $id= validate($id);
    $query ="SELECT * from $table WHERE id='$id' LIMIT 1";
    $result =mysqli_query($conn,$query);

    if($result){
        if(mysqli_num_rows($result)==1){
            $row= mysqli_fetch_assoc($result);
            $response=[
            'status'=>200,
            'data'=>$row,
            'message'=>'Record found'
        ];
        return $response;
        }
        else{
             $response=[
            'status'=>404,
            'message'=>'No data found'
        ];
        return $response;
        }
    }

    else{
        $response=[
            'status'=>500,
            'message'=>'Something went wrong'
        ];
        return $response;
    }
}

//delete data from database by using id
function delete($tableName,$id){
    global $conn;
    $table = validate($tableName);
    $id= validate($id);
    $query ="DELETE * from $table WHERE id='$id' LIMIT 1";
    $result =mysqli_query($conn,$query);
    return $result;
}

//alert Message function
function alertMessage(){
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>'.$_SESSION['status'].'</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';

        unset($_SESSION['status']);
    }
}

//check parameter
function checkParamId($type){
    if(isset($_GET[$type])){
        if($_GET[$type]!=''){
        return $_GET[$type];
        }
        else{
            return '<h5>No id found</h5>';
        }
    }else{
        return '<h5>No id given</h5>';
    }
}
//logout section
function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}
?>
