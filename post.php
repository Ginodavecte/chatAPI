<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database
include_once 'database.php';

//both value and mykey must be set for posting a message to db. duplicate values and mykey in db is oke
if(isset($_GET['value']) && isset($_GET['mykey']) ){
    $value = $_GET['value'];
    $mykey = $_GET['mykey'];

    //query for inserting values to db
    $sql = "INSERT INTO messages(mykey,value) VALUES ('$mykey','$value')";
    $result = mysqli_query($connection,$sql);
    //query for retrieving data from latest input to db
    $sql2 = "SELECT * FROM messages ORDER BY messages.id DESC LIMIT 1";
    $result2 = mysqli_query($connection,$sql2);
    $subject = mysqli_fetch_assoc($result2);
    //translate php to JSON
    echo json_encode($subject['id']);

}else{
    echo json_encode(
        array("message" => "A message value or mykey value is missing. Please try again.")
    );
}


