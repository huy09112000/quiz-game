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

if (isset($_GET['getHighScore'])) {
    //craete session to store correct answer
    $rankingList = getRankingList($GLOBALS['conn']);
    echo json_encode($rankingList);
  }