<?php
session_start();
$nickname = $_SESSION['nickname'] ?? 'Guest';
$totalScore = $_SESSION['score'] ?? 0;

// End session
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goodbye!</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Thank you for playing!</h1>
    <p><strong>Nickname:</strong> <?= htmlspecialchars($nickname) ?></p>
    <p><strong>Total Score:</strong> <?= $totalScore ?></p>

    <a class="button" href="index.php">Start New Game</a>
</div>
</body>
</html>
