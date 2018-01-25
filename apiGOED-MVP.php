<?php
// include database
include_once 'database.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // required headers (has to be inside if statement otherwise html wont work)
//    header("Access-Control-Allow-Origin: *");
//    header("Content-Type: application/json; charset=UTF-8");

        $value = $_POST['value'];
        $mykey = $_POST['mykey'];

        //query for inserting values to db
        $sql = "INSERT INTO messages(mykey,value) VALUES ('$mykey','$value')";
        $result = mysqli_query($connection,$sql);
        //query for retrieving data from latest input to db
        $sql2 = "SELECT * FROM messages ORDER BY messages.id DESC LIMIT 1";
        $result2 = mysqli_query($connection,$sql2);
        $subject = mysqli_fetch_assoc($result2);
        //translate php to JSON
        echo json_encode($subject['id']);
        exit();//has to end script here otherwise html form wil be shown on site
    }else{

//if id is set in url then perform sql on selected id else perform sql on all id's
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM messages WHERE id = $id";
    }else{
        $sql = "SELECt * FROM messages";
    }

    $result = mysqli_query($connection, $sql);

// check if more than 0 record found
    if($result->num_rows > 0){

        // products array
        $result_arr=array();
        $result_arr["messages"]=array();

        // retrieve our table contents
        while ($row = mysqli_fetch_assoc($result) ){

            $product_item=array(
                "id" => $row["id"],
                "mykey" => $row["mykey"],
                "value" => $row["value"]
            );

            array_push($result_arr["messages"], $product_item);
        }
        //translate php code to JSON
        echo json_encode($result_arr);
    }

    else{
        echo json_encode(
            array("message" => "No id's found.")
        );
    }
}
    ?>

    <form method="post">
        <input type="text" name="mykey"><br>
        <input type="text" name="value"><br>
        <input type="submit" name="submitPOST" value="Submit">
    </form>
