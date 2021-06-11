<?php
require_once 'dbcontext.php';
session_start();

//return result of answer
if (isset($_POST['ans'])) {
    // $correctAnswer = $_SESSION['correctAns']; //get the correct answer on session
    $userAnswer = $_POST['ans']; //get the value of user answer
    $questionId = $_POST['questionId'];
    $correctAnswer = getCorrectAnswer($questionId, $GLOBALS['conn']);
    $result = false; //result
  
    if ($userAnswer == $correctAnswer) {
      $result = true;
    }
    echo json_encode($result);
  }
