<?php
session_start();

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = htmlspecialchars($_POST["nickname"]);
    $topic = htmlspecialchars($_POST["topic"]);

    // Start session if not already
    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
    }

    $_SESSION['nickname'] = $nickname;

    // Redirect to quiz page with selected topic
    header("Location: quiz.php?topic=$topic");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kids Learning Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Kids Learning Game!</h1>
        <form method="post" action="index.php">
            <label for="nickname">Enter your nickname:</label><br>
            <input type="text" name="nickname" id="nickname" required><br><br>

            <label for="topic">Choose a quiz topic:</label><br>
            <select name="topic" id="topic" required>
                <option value="science">Science and Nature</option>
                <option value="numbers">Numbers</option>
            </select><br><br>

            <button type="submit">Start Quiz</button>
        </form>

        <br>
        <a href="leaderboard.php" class="button">View Leaderboard</a>
        <a href="exit.php" class="button">Exit</a>
    </div>
</body>
</html>