<?php
$leaderboard = [];
$sort = $_GET['sort'] ?? 'score'; // default sorting

if (file_exists("leaderboard.txt")) {
    $lines = file("leaderboard.txt", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($name, $score) = explode('|', $line);
        $leaderboard[$name] = (int)$score;
    }

    if ($sort == 'name') {
        ksort($leaderboard);
    } else {
        arsort($leaderboard);
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
    <a class="button" href="?sort=name">Sort by Name</a>
    <a class="button" href="?sort=score">Sort by Score</a>

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
