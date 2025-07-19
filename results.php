<?php
session_start();

$nickname = $_SESSION['nickname'] ?? 'Unknown';
$correct = $_SESSION['correct'] ?? 0;
$incorrect = $_SESSION['incorrect'] ?? 0;
$quizScore = ($correct * 3) - ($incorrect * 2);

// Accumulate session score
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
$_SESSION['score'] += $quizScore;
$totalScore = $_SESSION['score'];

// Update leaderboard.txt
$leaderboard = [];
$filename = "leaderboard.txt";

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($name, $score) = explode('|', $line);
        $leaderboard[$name] = (int)$score;
    }
}

$leaderboard[$nickname] = $totalScore;

file_put_contents($filename, "");
foreach ($leaderboard as $name => $score) {
    file_put_contents($filename, "$name|$score\n", FILE_APPEND);
}
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
    <p><strong>Correct:</strong> <?= $correct ?></p>
    <p><strong>Incorrect:</strong> <?= $incorrect ?></p>
    <p><strong>Score for this quiz:</strong> <?= $quizScore ?></p>
    <p><strong>Total Score:</strong> <?= $totalScore ?></p>

    <a class="button" href="index.php">Take Another Quiz</a>
    <a class="button" href="leaderboard.php">View Leaderboard</a>
    <a class="button" href="exit.php">Exit Game</a>
</div>
</body>
</html>
