<?php
$db = new SQLite3('data.db');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $c = $_POST['comment'];
    // intentionally no filtering stored XSS
    $stmt = $db->prepare('INSERT INTO comments (comment) VALUES (:c)');
    $stmt->bindValue(':c', $c, SQLITE3_TEXT);
    $stmt->execute();
}
$res = $db->query('SELECT id, comment FROM comments ORDER BY id DESC LIMIT 20');
echo "<h2>Public Comment Board</h2>";
echo "<form method='post'><textarea name='comment' rows='4'></textarea><br><input type='submit' value='Post'></form>";
echo "<hr>";
while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
    echo "<div class='comment'>" . $r['comment'] . "</div><hr>";
}
?>
