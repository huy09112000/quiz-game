<?php
include_once 'dbcontext.php';

if (isset($_POST['userName'])) {
    //craete session to store correct answer
    $name = $_POST['userName'];
    $result = checkExistName($GLOBALS['conn'], $name);
    echo json_encode($result);
}
