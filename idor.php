<?php
$db = new SQLite3('data.db');
$id = isset($_GET['user']) ? intval($_GET['user']) : 0;
$row = $db->querySingle("SELECT id, username, email, secret_note FROM users WHERE id = $id", true);
if (!$row) {
    echo "User not found";
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>VulnApp — User Profile</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    body {
      background: linear-gradient(180deg, #071224 0%, #071226 45%, #06111a 100%);
      color: var(--text);
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .profile-container {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255,255,255,0.03);
      text-align: center;
      width: 400px;
    }
    .profile-container h2 {
      margin-bottom: 20px;
      color: var(--accent);
    }
    .profile-container p {
      margin: 10px 0;
      color: var(--text);
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h2>Profile: <?php echo htmlspecialchars($row['username']); ?></h2>
    <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
    <p>Secret note: <?php echo htmlspecialchars($row['secret_note']); ?></p>
  </div>
</body>
</html>