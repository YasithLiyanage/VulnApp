<?php
$db = new SQLite3('data.db');
$id = isset($_GET['user']) ? intval($_GET['user']) : 0;
$row = $db->querySingle("SELECT id, username, email, secret_note FROM users WHERE id = $id", true);
if (!$row) {
    echo "User not found";
    exit;
}
echo "<h2>Profile: " . htmlspecialchars($row['username']) . "</h2>";
echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
// secret_note is sensitive, should be accessible only by logged-in user (not implemented here)
echo "<p>Secret note: " . htmlspecialchars($row['secret_note']) . "</p>";
?>
