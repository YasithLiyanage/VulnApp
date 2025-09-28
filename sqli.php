<?php
$db = new SQLite3('data.db');

$q = isset($_GET['q']) ? $_GET['q'] : '';
echo "<h2>Search Users</h2>";
echo "<form><input name='q' value='".htmlspecialchars($q)."'><input type='submit' value='Search'></form>";

if ($q !== '') {
    // intentionally vulnerable (no parameterized query)
    $sql = "SELECT id, username, bio FROM users WHERE username LIKE '%$q%'";
    $res = $db->query($sql);
    echo "<ul>";
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
        echo "<li><b>" . htmlspecialchars($row['username']) . "</b> - " . htmlspecialchars($row['bio']) . "</li>";
    }
    echo "</ul>";
}
?>
