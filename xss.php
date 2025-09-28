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
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>VulnApp — Public Comment Board</title>
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
    .comment-container {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255,255,255,0.03);
      text-align: center;
      width: 400px;
    }
    .comment-container h2 {
      margin-bottom: 20px;
      color: var(--accent);
    }
    .comment-container form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .comment-container textarea {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 10px;
      width: 100%;
      box-sizing: border-box;
      resize: vertical;
    }
    .comment-container input[type="submit"] {
      background: linear-gradient(180deg, var(--accent), var(--accent-2));
      color: #042027;
      padding: 10px 20px;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      box-shadow: 0 6px 14px rgba(6,182,212,0.12);
      transition: transform 0.12s ease, box-shadow 0.12s ease;
    }
    .comment-container input[type="submit"]:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(6,182,212,0.16);
    }
    .comments {
      margin-top: 20px;
      width: 100%;
    }
    .comment {
      background: rgba(255,255,255,0.05);
      margin: 5px 0;
      padding: 10px;
      border-radius: 10px;
      word-wrap: break-word;
      color: var(--text);
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="comment-container">
    <h2>Public Comment Board</h2>
    <form method='post'>
      <textarea name='comment' rows='4'></textarea><br>
      <input type='submit' value='Post'>
    </form>
    <div class="comments">
      <?php while ($r = $res->fetchArray(SQLITE3_ASSOC)): ?>
        <div class='comment'><?php echo $r['comment']; ?></div><hr>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>