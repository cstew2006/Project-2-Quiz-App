<?php
/*
 * PHP Techdegree Project 2: Build a Quiz App in PHP
 *
 * These comments are to help you get started.
 * You may split the file and move the comments around as needed.
 *
 * You will find examples of formating in the index.php script.
 * Make sure you update the index file to use this PHP script, and persist the users answers.
 *
 * For the questions, you may use:
 *  1. PHP array of questions
 *  2. json formated questions
 *  3. auto generate questions
 *
 */
 session_start();

// Include questions
include 'generate_questions.php';

// Keep track of which questions have been asked
$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
if (empty($page)) {
    session_destroy();
    $page = 1;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
// Show which question they are on
echo '<p class="breadcrumbs">Question ' . $page . ' of ' . $total . ' </p>';
   echo '<p class="quiz">What is ' . $questions[$page - 1]['leftAdder'] . ' + ' . $questions[$page - 1]['rightAdder'] . '?</p>';
   echo '<form action="index.php?p=' . ($page + 1) . '" method="post">';
   echo '<input type="hidden" name="correctAnswer" value="' . $questions[$page - 1]['correctAnswer'] . '" />';

// Show random question
  echo '<div id="quiz-box">';

// Shuffle answer buttons
function checkAnswer() {
    $answers = [];
    if (isset($_POST['answer1'])) {
        $_SESSION['answer1'] = filter_input(INPUT_POST, 'answer1', FILTER_SANITIZE_NUMBER_INT);
        $answers = [$_SESSION['answer1']];
    } elseif (isset($_POST['answer2'])) {
        $_SESSION['answer2'] = filter_input(INPUT_POST, 'answer2', FILTER_SANITIZE_NUMBER_INT);
        $answers = [$_SESSION['answer2']];
    } elseif (isset($_POST['answer3'])) {
        $_SESSION['answer3'] = filter_input(INPUT_POST, 'answer3', FILTER_SANITIZE_NUMBER_INT);
        $answers = [$_SESSION['answer3']];
    }
    if (isset($_POST['correct'])) {
        $_SESSION['correct'] = filter_input(INPUT_POST, 'correct', FILTER_SANITIZE_NUMBER_INT);
    }
    foreach ($answers as $answer) {
        if ($answer == $_SESSION['correct']) {
            echo "<p class='breadcrumbs'>Correct!</p>";
            ++$_SESSION['score'];
        } else {
            echo "<p class='breadcrumbs'>That is incorrect! The right answer was " . $_SESSION['correct'] . ".</p>";
        }
    }
    return $_SESSION['score'];
}
function restart() {
    echo "<form action='index.php' method='post'>";
    echo "<input type='submit' class='btn' name='restart' value='Take the quiz again'>";
    echo "</form>";
}

// Shows the score
function score() {
    $score = checkAnswer();
    echo "<p class='quiz'>Your final score is " . $score . " out of 10.</p>";
}

?>
