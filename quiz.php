<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizQuestions = $_SESSION['quizQuestions'] ?? [];
    $topic = $_SESSION['topic'] ?? '';

    $correct = 0;
    $incorrect = 0;

    foreach ($quizQuestions as $index => $line) {
        list($question, $answer) = explode('|', trim($line));
        $userAnswer = trim($_POST["answer$index"] ?? '');

        if ($topic === 'science') {
            // Case-insensitive match
            if (strcasecmp($userAnswer, trim($answer)) === 0) {
                $correct++;
            } else {
                $incorrect++;
            }
        } else {
            // Number-based: exact match
            if ($userAnswer === trim($answer)) {
                $correct++;
            } else {
                $incorrect++;
            }
        }
    }

    $_SESSION['correct'] = $correct;
    $_SESSION['incorrect'] = $incorrect;

    header("Location: results.php");
    exit;
}

// Initial GET setup
if (!isset($_GET['topic']) || !isset($_SESSION['nickname'])) {
    die("Error: Missing topic or nickname.");
}

$topic = $_GET['topic'];
$filename = "$topic.txt";

if (!file_exists($filename)) {
    die("Error: Topic file not found.");
}

$allQuestions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
shuffle($allQuestions);
$quizQuestions = array_slice($allQuestions, 0, 3);

$_SESSION['quizQuestions'] = $quizQuestions;
$_SESSION['topic'] = $topic;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz - <?= ucfirst($topic) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1><?= ucfirst($topic) ?> Quiz</h1>
    <form method="post">
        <?php foreach ($quizQuestions as $index => $line): 
            list($question, $answer) = explode('|', $line); ?>
            <p><strong><?= htmlspecialchars($question) ?></strong></p>
            <?php if ($topic === 'science'): ?>
                <label><input type="radio" name="answer<?= $index ?>" value="True" required> True</label>
                <label><input type="radio" name="answer<?= $index ?>" value="False"> False</label>
            <?php else: ?>
                <input type="text" name="answer<?= $index ?>" required placeholder="Enter answer">
            <?php endif; ?>
            <br><br>
        <?php endforeach; ?>
        <button type="submit">Submit Answers</button>
    </form>
</div>
</body>
</html>
