<?php
// xss.php - TechBlog styled stored XSS demo (CTF)
// ---------------------------
// WARNING: This file is intentionally insecure for CTF/learning purposes.
// Do NOT deploy on the public internet or any production environment.
// ---------------------------

// Set a flag in a cookie for the CTF challenge
if (!isset($_COOKIE['flag'])) {
    setcookie('flag', 'xss_c00k13_st34l_5ucc3ss', time() + 3600, '/', '', false, false);
}

// Initialize SQLite database (create if missing)
$dbFile = __DIR__ . '/data.db';
$init = !file_exists($dbFile);
$db = new SQLite3($dbFile);

// Create comments table if not exists (safe to run every time)
if ($init) {
    $db->exec('CREATE TABLE IF NOT EXISTS comments (id INTEGER PRIMARY KEY AUTOINCREMENT, comment TEXT)');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $c = $_POST['comment'];
    // Intentionally no filtering - stored XSS vulnerability (CTF)
    try {
        $stmt = $db->prepare('INSERT INTO comments (comment) VALUES (?)');
        $stmt->bindValue(1, $c, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            $success_msg = "Comment added successfully!";
        } else {
            $error_msg = "Failed to add comment.";
        }
    } catch (Exception $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

// Fetch recent comments
$res = $db->query('SELECT id, comment FROM comments ORDER BY id DESC LIMIT 20');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>TechBlog - Comments (CTF)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* TechBlog base styles (from your sample) */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background: #f4f4f4; color: #333; line-height: 1.45; }
    a { color: inherit; }

    /* Header */
    .header { background: #2c3e50; color: white; padding: 1rem 0; border-bottom: 3px solid #3498db; }
    .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
    .header h1 { font-size: 1.8rem; }
    .header nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 600; }
    .header nav a:hover { color: #3498db; }

    /* Banner */
    .banner { background: #3498db; color: white; text-align: center; padding: 2.2rem 20px; position: relative; margin-bottom: 20px; }
    .banner h2, .banner p { position: relative; z-index: 1; }
    .banner h2 { font-size: 1.8rem; margin-bottom: 0.25rem; }

    /* Layout container */
    .content { max-width: 1200px; margin: 2rem auto; padding: 0 20px; }

    /* Blog layout samples (kept minimal here) */
    .boxes { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 2rem; }

    .box { background: white; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
    .box h3 { color: #2c3e50; margin-bottom: 10px; }
    .box p { color: #666; margin-bottom: 10px; }

    /* Comments area styling (styled to blend with TechBlog) */
    .comment-board {
      background: white;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 24px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.04);
      max-width: 900px;
      margin: 0 auto;
    }

    .comment-board h2 { color: #2c3e50; margin-bottom: 12px; font-size: 1.4rem; }
    .comment-board form { display: flex; flex-direction: column; gap: 12px; margin-bottom: 18px; }
    .comment-board textarea {
      min-height: 90px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      resize: vertical;
      font-family: inherit;
      font-size: 14px;
    }
    .comment-board input[type="submit"] {
      display: inline-block;
      background: #3498db;
      color: white;
      padding: 10px 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      width: fit-content;
    }
    .comment-board input[type="submit"]:hover { background: #2980b9; }

    .notice { padding: 10px; border-radius: 6px; margin-bottom: 10px; font-size: 0.95rem; }
    .notice.success { background: #e6ffed; color: #116530; border: 1px solid #c6f6d5; }
    .notice.error { background: #fff0f0; color: #a00; border: 1px solid #f5c2c2; }

    .comments { margin-top: 10px; }
    .comment {
      background: #fafafa;
      border: 1px solid #eee;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 10px;
      word-wrap: break-word;
    }
    .comment .meta { font-size: 12px; color: #888; margin-bottom: 8px; }

    /* Footer */
    .footer { background: #2c3e50; color: white; text-align: center; padding: 1.5rem; margin-top: 3rem; }

    /* Responsive */
    @media (max-width: 768px) {
      .boxes { grid-template-columns: 1fr; }
      .header .container { flex-direction: column; gap: 12px; }
      .header nav { margin-top: 8px; }
    }
  </style>
</head>
<body>

  <!-- Header (TechBlog) -->
  <div class="header">
    <div class="container">
      <h1>TechBlog</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="sqli.php">Authors</a>
        <a href="xss.php">Comments</a>
        <a href="idor.php?user=1">Profile</a>
      </nav>
    </div>
  </div>

  <!-- Banner -->
  <div class="banner">
    <h2>Welcome to TechBlog</h2>
    <p>Your source for technology news and articles</p>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="comment-board" role="main" aria-labelledby="comments-title">
        <h2 id="comments-title">Discussion Board - Public Comments (CTF)</h2>

        <?php if (isset($error_msg)): ?>
            <div class="notice error" role="alert"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>

        <?php if (isset($success_msg)): ?>
            <div class="notice success"><?php echo htmlspecialchars($success_msg); ?></div>
        <?php endif; ?>

        <form method="post" action="xss.php" autocomplete="off">
            <label for="comment" style="font-weight:600; color:#2c3e50;">Share your thoughts</label>
            <textarea name="comment" id="comment" placeholder="Write a comment... (JS allowed for CTF)" required></textarea>
            <input type="submit" value="Post Comment">
        </form>

        <div class="comments" aria-live="polite">
            <h3 style="font-size:1rem; color:#2c3e50; margin-bottom:8px;">Recent Comments</h3>

            <?php
            $hasComments = false;
            while ($r = $res->fetchArray(SQLITE3_ASSOC)):
                $hasComments = true;
            ?>
                <div class="comment" id="c-<?php echo (int)$r['id']; ?>">
                    <div class="meta">Comment #<?php echo (int)$r['id']; ?></div>
                    <!-- Intentionally vulnerable: stored XSS (for CTF) -->
                    <?php echo $r['comment']; ?>
                </div>
            <?php endwhile; ?>

            <?php if (!$hasComments): ?>
                <div class="comment" style="font-style:italic; color:#666;">No comments yet. Be the first to share your thoughts!</div>
            <?php endif; ?>
        </div>

        <div style="margin-top:12px; font-size:0.95rem; color:#555;">
            <strong>CTF hint:</strong> This board stores raw HTML and JS. Try a client-side payload to reveal the cookie or read the flag cookie.
        </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>&copy; TechBlog. WS - Yasith Liyanage.</p>
  </div>

</body>
</html>
