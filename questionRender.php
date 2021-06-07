<?php
//control and handle request from user
session_start();

class quizz
{
  public $question;
  public $answer = array();
  public $correctAns;

  function set_question($question)
  {
    $this->question = $question;
  }
  function get_question()
  {
    return $this->question;
  }

  function set_answer($answer)
  {
    $this->answer = $answer;
  }
  function get_name()
  {
    return $this->answer;
  }

  function set_correctAns($correctAns)
  {
    $this->correctAns = $correctAns;
  }
  function get_correctAns()
  {
    return $this->correctAns;
  }
}

function randomQuizz()
{
  $quiz = new quizz();
  $firstNumber = random_int(0, 10);
  $secondNumber = random_int(0, 10);
  switch (random_int(1, 3)) {
    case 1:
      //+
      $correctAnswer = $firstNumber + $secondNumber;
      $question = $firstNumber . "+" . $secondNumber;
      break;
    case 2:
      //-
      $correctAnswer = $firstNumber - $secondNumber;
      $question = $firstNumber . "-" . $secondNumber;
      break;
    case 3:
      //*
      $correctAnswer = $firstNumber * $secondNumber;
      $question = $firstNumber . "x" . $secondNumber;
      break;
  }
  //random like this to avoid duplicate answer
  $answer = array($correctAnswer, $correctAnswer + 1, $correctAnswer - $firstNumber - $secondNumber, $correctAnswer + $firstNumber +$secondNumber) ;
  shuffle($answer);

  $quiz->set_question($question);
  $quiz->set_answer($answer);
  $quiz->set_correctAns($correctAnswer);

  return $quiz;
}

//return new quizz in each call
if (isset($_GET['questionRequest'])) {
  $quizz = randomQuizz();
  //craete session to store correct answer
  $_SESSION["correctAns"] = $quizz->get_correctAns();

  echo json_encode($quizz);
}
