<?php
include_once 'dbcontext.php';

function existName($name)
{
    //call to dbi and query
    // $sql = "SELECT * FROM `highscore` WHERE user_name = "+$name+";";
    $sql ="SELECT * FROM `highscore` WHERE user_name = '{$name}'";

    $result = mysqli_query($GLOBALS['conn'], $sql) or die("Bad query: $sql");

    //get total rows
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
        //exist data
            return true;
        }
    }
    return false;
}

if (isset($_POST['userName'])) {
    //craete session to store correct answer
    $name = $_POST['userName'];
    $result = existName($name);
    echo json_encode($result);
}
