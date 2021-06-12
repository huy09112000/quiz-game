<?php
$dbServerName = 'localhost';
$dbUserName = 'root';
$dbPassword = '';
$dbName = 'quizdb';

$conn = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName) or die("Unable to connect!");

/*
    return the correct answer by question id
*/
function getCorrectAnswer(int $qid, mysqli $conn)
{
    $sqlQuerry = $conn->prepare("SELECT correctAnswer FROM question_bank WHERE questionID = ?");
    $sqlQuerry->bind_param('i', $qid);
    $sqlQuerry->execute();
    $row = mysqli_fetch_assoc($sqlQuerry->get_result());
    return $row['correctAnswer'];
}

/*
    return question select by question id
*/
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

/*
    return max question id
*/
function questionIdCount(mysqli $conn): int
{
    $sqlQuerry = $conn->prepare("SELECT MAX(questionID) FROM `question_bank`");
    $sqlQuerry->execute();
    $row = mysqli_fetch_assoc($sqlQuerry->get_result());
    return $row['MAX(questionID)'];
}

/*
    insert highscore to database
*/
function insertHighScore(mysqli $conn, string $userName, int $score): bool
{
    $sqlQuerry = $conn->prepare("INSERT INTO `highscore`(`user_name`, `score`) VALUES ('{$userName}','{$score}')");
    return $sqlQuerry->execute();
}

/*
    return list of top 5 highscore
*/
function getRankingList(mysqli $conn): array
{
    //call to dbi and query
    $sql = "SELECT * FROM `highscore` ORDER BY score DESC LIMIT 5;";

    $result = mysqli_query($conn, $sql) or die("Bad query: $sql");

    //get total rows
    $resultCheck = mysqli_num_rows($result);
    $rankingList = array();
    if ($resultCheck > 0) {
        //exist data
        //fetch data to single access of row
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new userRecord();
            $user->set_userName($row['user_name']);
            $user->set_score($row['score']);
            //add to list
            // $rankingList[] = $user;
            array_push($rankingList, $user);
        }
    }
    return $rankingList;
}


function checkExistName(mysqli $conn, string $name): bool
{
    //call to dbi and query
    // $sql = "SELECT * FROM `highscore` WHERE user_name = "+$name+";";
    $sql = "SELECT * FROM `highscore` WHERE user_name = '{$name}'";
    $result = mysqli_query($conn, $sql) or die("Bad query: $sql");
    //get total rows
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        return true;
    }
    return false;
}
