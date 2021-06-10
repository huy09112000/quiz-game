<?php
include_once 'dbcontext.php';

class userRecord
{
    public $userName;
    public $score;

    function set_userName($userName)
    {
        $this->userName = $userName;
    }
    function get_userName()
    {
        return $this->userName;
    }

    function set_score($score)
    {
        $this->score = $score;
    }
    function get_score()
    {
        return $this->score;
    }
}

function getRankingList()
{
    //call to dbi and query
    $sql = "SELECT * FROM `highscore` ORDER BY score DESC LIMIT 5;";

    $result = mysqli_query($GLOBALS['conn'], $sql) or die("Bad query: $sql");

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

if (isset($_GET['getHighScore'])) {
    //craete session to store correct answer
    $rankingList = getRankingList();
    echo json_encode($rankingList);
  }