<?php
$dbServerName = 'localhost';
$dbUserName = 'root';
$dbPassword = '';
$dbName = 'quizdb';

$conn = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName) or die("Unable to connect!");

function getCorrectAnswer(int $qid, mysqli $conn)
{
    $sqlQuerry = $conn->prepare("SELECT correctAnswer FROM question_bank WHERE questionID = ?");
    $sqlQuerry->bind_param('i', $qid);
    $sqlQuerry->execute();
    $row = mysqli_fetch_assoc($sqlQuerry->get_result());
    return $row['correctAnswer'];
}

function getQuestion(int $questionID, mysqli $conn): quizz
{
    $quiz = new quizz();

    $sqlQuerry = $conn->prepare("SELECT questionID, question, answer1, answer2, answer3, answer4 FROM question_bank WHERE questionID = ?");

    $sqlQuerry->bind_Param('i', $questionID);
    $sqlQuerry->execute();
    $row = mysqli_fetch_assoc($sqlQuerry->get_result());

    if ($row > 0) {
        $quiz->set_questionId($row['questionID']);
        $quiz->set_question($row['question']);
        $ans = array($row['answer1'], $row['answer2'], $row['answer3'], $row['answer4']);
        $quiz->set_answer($ans);
    } else {
        return null;
    }
    return $quiz;
}

function questionIdCount(mysqli $conn):int
{
    $sqlQuerry = $conn->prepare("SELECT MAX(questionID) FROM `question_bank`");
    $sqlQuerry->execute();
    $row = mysqli_fetch_assoc($sqlQuerry->get_result());
    return $row['MAX(questionID)'];
}

