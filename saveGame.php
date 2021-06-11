<?php

include_once 'dbcontext.php';

if (isset($_POST['score'])) {

    $result = true;
    $userName = $_POST['userName'];
    $score = $_POST['score'];
    $sql = "INSERT INTO `highscore`(`user_name`, `score`) VALUES ('{$userName}','{$score}')";
    
    try {
        $conn->query($sql);
    } catch (Exception $e) {
        $result = false;
    }
    echo json_encode($result);
}
