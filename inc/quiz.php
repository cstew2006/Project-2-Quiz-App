<?php
session_start();
if (!isset($_SESSION['amountCorrect'])) {
    $_SESSION['amountCorrect'] = 0;
} 
// Include questions
include 'generate_questions.php';
// var_dump($questions);
$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
if (empty($page)) {
    session_destroy();
    $page = 1;
}
$total = count($questions);
// Show score
if ($page <= 10) {
    // Show random question
    echo '<div id="quiz-box">';
 
    // Show which question they are on
    echo '<p class="breadcrumbs">Question ' . $page . ' of ' . $total . ' </p>';
    echo '<p class="quiz">What is ' . $questions[$page - 1]['leftAdder'] . ' + ' . $questions[$page - 1]['rightAdder'] . '?</p>';
    echo '<form action="index.php?p=' . ($page + 1) . '" method="post">';
    echo '<input type="hidden" name="correctAnswer" value="' . $questions[$page - 1]['correctAnswer'] . '" />';
    
 
 // Shuffle answer buttons
    $answers = [
        $questions[$page - 1]['correctAnswer'], 
        $questions[$page - 1]['firstIncorrectAnswer'], 
        $questions[$page - 1]['secondIncorrectAnswer']
    ];
  
  
  
    shuffle($answers);
    echo '<input type="submit" class="btn" name="answer" value="' . $answers[0] . '" />';
    echo '<input type="submit" class="btn" name="answer" value="' . $answers[1] . '" />';
    echo '<input type="submit" class="btn" name="answer" value="' . $answers[2] . '" />';
    echo '</form>';
    echo '</div>';
} else if ($page == 11) {
    echo '<h1 class="quiz">The Quiz is Finished</h1>';
    echo '<form action="index.php?p=' . ($page + 1) . '" method="post">';
    echo '<input type="submit" class="btn" name="answer" value="Check Your Grade" />';
    echo '</form>';
} else if ($page == 12) {
    echo '<h1 class="quiz">You got an</h1>';
    echo '<p>You got '. $_SESSION['amountCorrect'] . ' out of ' . $total . ' questions!</p>';
    echo '<form action="index.php">';
    echo '<input type="submit" class="btn" name="quiz" value="You Will Need to Retake This Quiz" />';
    echo '</form>';
    echo '<style>h1, p {color: orange;} p {font-size: 2rem;}</style>';
}


// Keep track of which questions have been asked
// Keep track of answers
if (isset($_POST['answer']) && isset($_POST['correctAnswer'])) {
    $_SESSION['answer'] = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['correctAnswer'] = filter_input(INPUT_POST, 'correctAnswer', FILTER_SANITIZE_NUMBER_INT);
    if ($_SESSION['answer'] == $_SESSION['correctAnswer']) {
        // Toast correct and incorrect answers
        echo '<h2>Excellent! That is correct!</h2>';
        $_SESSION['amountCorrect']++;
    } else {
        echo '<h2>Sorry, the answer was ' . $_SESSION['correctAnswer'] . ' .</h2>';
    }
}

?>
