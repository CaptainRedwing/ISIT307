<?php
session_start();

// Initialize
$correct = isset($_SESSION['correct']) ? $_SESSION['correct'] : 0;
$incorrect = isset($_SESSION['incorrect']) ? $_SESSION['incorrect'] : 0;
$nickname = $_SESSION['nickname'] ?? 'Guest';

// Calculate quiz score
$quizScore = ($correct * 3) - ($incorrect * 2);
$_SESSION['score'] += $quizScore;
$overallScore = $_SESSION['score'];

// Store leaderboard data
$leaderboardFile = "leaderboard.txt";
$leaderboard = [];

if (file_exists($leaderboardFile)) {
    $lines = file($leaderboardFile, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($name, $score) = explode('|', $line);
        $leaderboard[$name] = (int)$score;
    }
}

$leaderboard[$nickname] = ($leaderboard[$nickname] ?? 0) + $quizScore;

// Save updated leaderboard
$fp = fopen($leaderboardFile, 'w');
foreach ($leaderboard as $name => $score) {
    fwrite($fp, "$name|$score\n");
}
fclose($fp);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Quiz Results</h1>
    <p>Correct Answers: <?= $correct ?></p>
    <p>Incorrect Answers: <?= $incorrect ?></p>
    <p>Score this quiz: <?= $quizScore ?></p>
    <p>Overall Score: <?= $overallScore ?></p>
    
    <a class="button" href="index.php">Take Another Quiz</a>
    <a class="button" href="leaderboard.php">View Leaderboard</a>
    <a class="button" href="exit.php">Exit Game</a>
</div>
</body>
</html>
