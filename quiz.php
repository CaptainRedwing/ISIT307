<?php
session_start();

if (!isset($_GET['topic']) || !isset($_SESSION['nickname'])) {
    die("Error: Missing topic or nickname.");
}

$topic = htmlspecialchars($_GET['topic']);
$nickname = $_SESSION['nickname'];
$filename = "$topic.txt";

// Load question file
if (!file_exists($filename)) {
    die("Error: Question file not found.");
}

$allQuestions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
shuffle($allQuestions); // Randomize
$quizQuestions = array_slice($allQuestions, 0, 3); // Pick 3

$_SESSION['quizQuestions'] = $quizQuestions;
$_SESSION['topic'] = $topic;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz: <?= ucfirst($topic) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Quiz: <?= ucfirst($topic) ?></h1>
        <form method="post" action="results.php">
            <?php foreach ($quizQuestions as $index => $line): 
                list($questionText, $correctAnswer) = explode('|', $line);
            ?>
                <p><strong><?= htmlspecialchars($questionText) ?></strong></p>
                <?php if ($topic === 'science'): ?>
                    <label><input type="radio" name="answer<?= $index ?>" value="True" required> True</label>
                    <label><input type="radio" name="answer<?= $index ?>" value="False"> False</label>
                <?php else: ?>
                    <input type="text" name="answer<?= $index ?>" required placeholder="Enter your answer">
                <?php endif; ?>
                <br><br>
            <?php endforeach; ?>
            <button type="submit">Submit Answers</button>
        </form>
        <br>
        <a href="index.php" class="button">Main Menu</a>
        <a href="exit.php" class="button">Exit</a>
    </div>
</body>
</html>
