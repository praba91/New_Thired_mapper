<?php

//  header('Access-Control-Allow-Origin:*');
//      header("Access-Control-Allow-Credentials: true");
//      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, 
// OPTIONS');
//      header('Access-Control-Max-Age: 1000');
//      header('Access-Control-Allow-Headers: Content-Type, Content-Range, 
// Content-Disposition, Content-Description,Origin');
// $test=file_get_contents("php://input");
// $input = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($test));
// $arr = json_decode($input); 
// $cashack=json_decode($input);


// function database_connect() {
// 	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASS) or die("Database Connection Error");
// 	if(!$con) {
// 	echo "could not connect"; exit;
// 	}
// 	$db=mysqli_select_db($con,DB_NAME) or die("Select Database Error");
// 	if(!$db) {
// 		echo "No database found"; exit;
// 	}
// }

// database_connect();

// function showDBData($selQuery) {
// 	$link = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
// 	$result = mysqli_query($link,$selQuery) or die(mysqli_error($link));
// 	$records=mysqli_fetch_all($result,MYSQLI_ASSOC);
// 	if($records!=null) {
// 		return $records;
// 	} else {
// 		return 0;
// 	}
// }

// function deleteDBData($delQuery) {
	
// 	$link = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
// 	$result = mysqli_query($link,$delQuery) or die("Delete Query Error -> ".mysqli_error($link));
// 	return mysqli_affected_rows($link);
// }

// // Update the DB Records
// function updateDBData($updateQuery) {
// 	$link = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
// 	$updateQueryRes = mysqli_query($link,$updateQuery) or die("Update Query Error -> ".mysqli_error($link));
// 	return mysqli_affected_rows($link);
// }

// // Inserting Records into DB
// function insertDBData($insertQuery) {
// 	$link = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
// 	$insertQueryRes = mysqli_query($link,$insertQuery) or die("Insert Query Error -> ".mysqli_error($link));
// 	return mysqli_insert_id($link);
// }



 
ini_set('memory_limit', '1024M');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 20000);
ini_set('max_execution_time', 20000);
ini_set('display_errors', 'ON');

$filename = 'eureka_uat2.sql';
$mysql_host = 'localhost';
$mysql_username = 'itdevelopers';
$mysql_password = 'develop@321';
$mysql_database = 'eureka_uat2';

$con=mysqli_connect($mysql_host, $mysql_username, $mysql_password,$mysql_database);


$fileObj = fopen( $filename, "rt" );    $templine='';
while (($line = fgets($fileObj))){
    
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;
    $templine .= $line;

    if (substr(trim($line), -1, 1) == ';'){
    
        $con->query($templine);
            $templine = '';
    }
    
}
echo 'ok';
?>
