<?php
//control and handle request from user
require_once 'dbContext.php';
session_start();

class quizz
{
  public $question;
  public $answer = array();
  public $questionId;

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
  function get_answer()
  {
    return $this->answer;
  }

  function set_questionId($questionId)
  {
    $this->questionId = $questionId;
  }
  function get_questionId()
  {
    return $this->questionId;
  }
}

if (isset($_GET['questionRequest'])) {
  //user do while loop to avoid missing question id in database  
  do {
    $quizz = getQuestion(random_int(1, questionIdCount($GLOBALS['conn'])), $GLOBALS['conn']);
  } while (is_null($quizz));
  //craete session to store correct answer
  echo json_encode($quizz);
}
