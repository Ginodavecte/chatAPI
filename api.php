<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database
include_once 'database.php';

$sql = "SELECT * FROM messages";
$result = mysqli_query($connection, $sql);

// check if more than 0 record found
if($result->num_rows > 0){

    // products array
    $result_arr=array();
    $result_arr["ids"]=array();

    // retrieve our table contents
    while ($row = mysqli_fetch_assoc($result) ){
      //      var_dump($row);

        $product_item=array(
            "id" => $row["id"],
            "mykey" => $row["mykey"],
            "value" => $row["value"]
        );

        array_push($result_arr["ids"], $product_item);
    }
    //var_dump($result_arr);


    echo json_encode($result_arr);
}

else{
    echo json_encode(
        array("message" => "No id's found.")
    );
}
?>