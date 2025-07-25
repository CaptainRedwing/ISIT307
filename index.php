<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['nickname'] = trim($_POST['nickname']);
    $_SESSION['score'] = 0;
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Welcome to the Learning Game</h1>
    <form method="post">
        <label for="nickname">Enter Nickname:</label>
        <input type="text" name="nickname" required>
        <button type="submit">Start</button>
    </form>

    <?php if (isset($_SESSION['nickname'])): ?>
        <h2>Hello, <?= htmlspecialchars($_SESSION['nickname']) ?>!</h2>
        <a class="button" href="quiz.php?topic=science">Science Quiz</a>
        <a class="button" href="quiz.php?topic=numbers">Numbers Quiz</a>
        <a class="button" href="quiz.php?topic=animals">Animals Quiz</a>
        <a class="button" href="quiz.php?topic=colours">Colours Quiz</a>
        <a class="button" href="quiz.php?topic=shapes">Shapes Quiz</a>
        <a class="button" href="quiz.php?topic=english">English Quiz</a>
        <a class="button" href="leaderboard.php">Leaderboard</a>
        <a class="button" href="exit.php">Exit</a>
    <?php endif; ?>
</div>
</body>
</html>
