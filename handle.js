var interval;
var time;
var score;
var currentQuestionId;

function setData(data, currentScore) {
    $("#question").text(data.question);
    $("#answer0").val(data.answer[0]);
    $("#answer1").val(data.answer[1]);
    $("#answer2").val(data.answer[2]);
    $("#answer3").val(data.answer[3]);
    score = currentScore;
    currentQuestionId = data.questionId;
    $(".score").text("Score: " + score);
    correctAnswer = data.correctAns;
}

function gameOver() {
    $(".correct").css("visibility", "hidden");
    $(".endGame").css("visibility", "visible");
    $('#startGame').text("Start Game");
    $("#lastScore").text("GAME OVER!YOUR SCORE IS " + score);
    clearInterval(interval);
    $(".ans").prop('disabled', true);
    $("#scoreBoard").css("visibility", "visible");
}

function startGame() {
    $(".correct").css("visibility", "hidden");
    $(".endGame").css("visibility", "hidden");
    $('#startGame').text("Reset Game");
    $(".ans").prop('disabled', false);
    // $("#scoreBoard").prop('disabled', true);
    $("#scoreBoard").css("visibility", "hidden");
    $(".highScore").css("visibility", "hidden");
    $(".answer").css("visibility", "visible");
    $(".question").css("visibility", "visible");
    $(".timer").css("visibility", "visible");
    $(".ct").css("visibility", "visible");
}

function showRank() {
    $(".highScore").css("visibility", "visible");
    $(".answer").css("visibility", "hidden");
    $(".question").css("visibility", "hidden");
    $(".timer").css("visibility", "hidden");
    $(".ct").css("visibility", "hidden");
    $(".endGame").css("visibility", "hidden");
}

function setScoreBoard(rankingList) {
    //set text
    var i;
    for (i = 0; i < rankingList.length; i++) {
        $("#top" + i + "Name").html(rankingList[i].userName);
        $("#top" + i + "Score").html(rankingList[i].score);
    }
}
$(document).ready(function() {
    $("#scoreBoard").click(function() {
        //call to server
        $.get("highScoreRender.php", { getHighScore: "get" }, function(res) {
            //list of high score
            var rankingList = JSON.parse(res);
            setScoreBoard(rankingList);
            //load data
        });

        showRank();
    });

    $('#startGame').click(function() {
        //sending get method to server to query question
        $.get("questionRender.php", { questionRequest: "start" }, function(res) {
            var quizz = JSON.parse(res);
            startGame();
            setData(quizz, 0);
        });
        timeCountDownStart();
    });

    $("#answer0, #answer1, #answer2, #answer3").click(function() {
        var $this = $(this);
        var userAnswer = $this.val();

        //sending post method to server to ask about the result
        $.post("answerCheck.php", {
            ans: userAnswer,
            questionId: currentQuestionId
        }, function(response) {
            var result = JSON.parse(response);
            if (result == true) {
                score++;
                //gen new question, update score
                $.get("questionRender.php", { questionRequest: "start" }, function(res) {
                    var quizz = JSON.parse(res);
                    startGame();
                    setData(quizz, score);
                });

            } else {
                gameOver();
            }
        })
    });

    $('#submitHighScore').click(function() {
        $name = $.trim($('#userName').val());
        $.post("checkDupUser.php", { userName: $name }, function(res) {
            var result = JSON.parse(res);
            if (result == true) {
                alert("The name: " + $name + " already exist in database, please choose another name!");
            } else {
                //post score and username
                $.post("saveGame.php", { userName: $name, score: score }, function(res) {
                    var result = JSON.parse(res);
                    if (result == true) {
                        alert("Save success!");
                        $('#userName').val("");
                        $("#scoreBoard").click();
                    } else {
                        alert("Save fail");
                    }
                });
            }
        })
    })
});

function timeCountDownStart() {
    clearInterval(interval); //clear every time click reset 
    const startingMinutes = 0.5; //set time here
    let time = (startingMinutes * 60) - 1;
    //set 1s
    interval = setInterval(function() {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        //check nếu sec < 10 thì thêm 0 ở trước sec (E.g: 03)
        seconds = seconds < 10 ? '0' + seconds : seconds;

        $('#countDown').text("Time remaining: " + `${minutes}:${seconds}`);
        // countDonwn.innerHTML = "timer";

        time--;
        console.log(time);
        if (time < 0) {
            gameOver();
        }
    }, 1000);
    $('#countDown').text("Time remaining: 0:30");
}