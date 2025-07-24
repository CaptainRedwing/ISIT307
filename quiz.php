<?php
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizQuestions = $_SESSION['quizQuestions'] ?? [];
    $topic = $_SESSION['topic'] ?? '';

    $correct = 0;
    $incorrect = 0;
    $_SESSION['userAnswers'] = []; // Store user answers for feedback

    foreach ($quizQuestions as $index => $line) {
        list($question, $answer) = explode('|', trim($line));
        $userAnswer = trim($_POST["answer$index"] ?? '');

        $_SESSION['userAnswers'][] = $userAnswer;

        if (strcasecmp($userAnswer, trim($answer)) === 0) {
            $correct++;
        } else {
            $incorrect++;
        }
    }

    $_SESSION['correct'] = $correct;
    $_SESSION['incorrect'] = $incorrect;

    header("Location: results.php");
    exit;
}

// Load quiz on GET
if (!isset($_GET['topic']) || !isset($_SESSION['nickname'])) {
    die("Error: Missing topic or nickname.");
}

$topic = htmlspecialchars($_GET['topic']);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz - <?= ucfirst($topic) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="<?= htmlspecialchars($topic) ?>">
    <div class="container">
        <h1><?= ucfirst($topic) ?> Quiz</h1>
        <form method="post">
            <?php foreach ($quizQuestions as $index => $line): 
                list($question, $answer) = explode('|', $line); ?>
                <p><strong><?= htmlspecialchars($question) ?></strong></p>
                <label><input type="radio" name="answer<?= $index ?>" value="True" required> True</label>
                <label><input type="radio" name="answer<?= $index ?>" value="False"> False</label>
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
