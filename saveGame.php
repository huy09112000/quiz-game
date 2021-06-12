<?php

include_once 'dbcontext.php';

if (isset($_POST['score'])) {

    $userName = $_POST['userName'];
    $score = $_POST['score'];
    
    echo json_encode(insertHighScore($GLOBALS['conn'],$userName,$score));
}
