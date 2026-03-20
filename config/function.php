<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbcon.php'; // IMPORTANT: prevent multiple inclusion

// ================= VALIDATE =================
if (!function_exists('validate')) {
    function validate($inputData){
        global $conn;
        $validatedData = mysqli_real_escape_string($conn, $inputData);
        return trim($validatedData);
    }
}

// ================= REDIRECT =================
if (!function_exists('redirect')) {
    function redirect($url, $status)
    {
        $_SESSION['status'] = $status;
        header('location:' . $url);
        exit(0);
    }
}

// ================= ALERT MESSAGE =================
if (!function_exists('alertMessage')) {
    function alertMessage(){
        if(isset($_SESSION['status'])){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h6>'.$_SESSION['status'].'</h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';

            unset($_SESSION['status']);
        }
    }
}

// ================= INSERT =================
if (!function_exists('insert')) {
    function insert($tableName, $data){
        global $conn;

        $table = validate($tableName);
        $columns = array_keys($data);
        $values = array_values($data);

        $finalColumn = implode(',', $columns);
        $finalValues = "'" . implode("','", $values) . "'";

        $query = "INSERT INTO $table($finalColumn) VALUES ($finalValues)";
        return mysqli_query($conn, $query);
    }
}

// ================= UPDATE =================
if (!function_exists('update')) {
    function update($tableName, $id, $data){
        global $conn;

        $table = validate($tableName);
        $id = validate($id);

        $updateDataString = "";

        foreach($data as $column => $value){
            $updateDataString .= $column . "='" . $value . "',";
        }

        $finalUpdateData = rtrim($updateDataString, ',');

        $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
        return mysqli_query($conn, $query);
    }
}

// ================= GET ALL =================
if (!function_exists('getAll')) {
    function getAll($tableName, $status = NULL)
    {
        global $conn;

        $table = validate($tableName);
        $status = validate($status);

        if($status == 'status'){
            $query = "SELECT * FROM $table WHERE status='0'";
        } else {
            $query = "SELECT * FROM $table";
        }

        return mysqli_query($conn, $query);
    }
}

// ================= GET BY ID =================
if (!function_exists('getById')) {
    function getById($tableName, $id)
    {
        global $conn;

        $table = validate($tableName);
        $id = validate($id);

        $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);

                return [
                    'status' => 200,
                    'data' => $row,
                    'message' => 'Record found'
                ];
            } else {
                return [
                    'status' => 404,
                    'message' => 'No data found'
                ];
            }
        } else {
            return [
                'status' => 500,
                'message' => 'Something went wrong'
            ];
        }
    }
}

// ================= DELETE =================
if (!function_exists('delete')) {
    function delete($tableName, $id){
        global $conn;

        $table = validate($tableName);
        $id = validate($id);

        $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
        return mysqli_query($conn, $query);
    }
}

// ================= CHECK PARAM ID =================
if (!function_exists('checkParamId')) {
    function checkParamId($type){
        if(isset($_GET[$type])){
            if($_GET[$type] != ''){
                return $_GET[$type];
            } else {
                return '<h5>No id found</h5>';
            }
        } else {
            return '<h5>No id given</h5>';
        }
    }
}

// ================= LOGOUT =================
if (!function_exists('logoutSession')) {
    function logoutSession()
    {
        unset($_SESSION['loggedIn']);
        unset($_SESSION['loggedInUser']);
    }
}

// ================= JSON RESPONSE =================
if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $status_type, $message){
        $response = [
            'status' => $status,
            'status_type' => $status_type,
            'message' => $message
        ];

        echo json_encode($response);
    }
}

// ================= COUNT =================
if (!function_exists('getCount')) {
    function getCount($tableName)
    {
        global $conn;

        $table = validate($tableName);
        $query = "SELECT * FROM $table";
        $query_run = mysqli_query($conn, $query);

        if($query_run){
            return mysqli_num_rows($query_run);
        } else {
            return '<h5>something went wrong</h5>';
        }
    }
}

?>