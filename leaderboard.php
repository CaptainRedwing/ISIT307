<?php
session_start();
$filename = "leaderboard.txt";
$leaderboard = [];

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($name, $score) = explode('|', $line);
        $leaderboard[$name] = (int)$score;
    }

    // Sorting
    if (isset($_GET['sort']) && $_GET['sort'] === 'name') {
        ksort($leaderboard, SORT_STRING);
    } else {
        arsort($leaderboard, SORT_NUMERIC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Leaderboard</h1>
    <div>
        <a class="button" href="?sort=score">Sort by Score</a>
        <a class="button" href="?sort=name">Sort by Name</a>
    </div>

    <table class="leaderboard-table">
        <tr>
            <th>Nickname</th>
            <th>Score</th>
        </tr>
        <?php foreach ($leaderboard as $name => $score): ?>
            <tr>
                <td><?= htmlspecialchars($name) ?></td>
                <td><?= $score ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a class="button" href="index.php">Back to Menu</a>
</div>
</body>
</html>
