<?php
session_start();
$nickname = $_SESSION['nickname'] ?? 'Guest';
$score = $_SESSION['score'] ?? 0;

// Destroy session after showing final message
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exit Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Thanks for playing!</h1>
    <p>Nickname: <?= htmlspecialchars($nickname) ?></p>
    <p>Total Score: <?= $score ?></p>

    <a class="button" href="index.php">Start New Game</a>
</div>
</body>
</html>
