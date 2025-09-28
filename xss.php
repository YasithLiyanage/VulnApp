<?php
// Set a flag in a cookie for the CTF challenge
if (!isset($_COOKIE['flag'])) {
    setcookie('flag', 'xss_c00k13_st34l_5ucc3ss', time() + 3600, '/', '', false, false);
}

// Initialize SQLite database
$db = new SQLite3('data.db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $c = $_POST['comment'];
    // Intentionally no filtering - stored XSS vulnerability
    try {
        $stmt = $db->prepare('INSERT INTO comments (comment) VALUES (?)');
        $stmt->bindValue(1, $c, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        // Add success message for debugging
        if ($result) {
            $success_msg = "Comment added successfully!";
        }
    } catch (Exception $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

// Fetch comments
$res = $db->query('SELECT id, comment FROM comments ORDER BY id DESC LIMIT 20');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VulnApp — Public Comment Board</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        :root {
            --text: #e2e8f0;
            --card: rgba(15, 23, 42, 0.8);
            --radius: 12px;
            --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --accent: #06b6d4;
            --accent-2: #0891b2;
        }

        body {
            background: linear-gradient(180deg, #071224 0%, #071226 45%, #06111a 100%);
            color: var(--text);
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 50px;
        }

        .comment-container {
            background: var(--card);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.03);
            text-align: center;
            width: 100%;
            max-width: 500px;
            backdrop-filter: blur(10px);
        }

        .comment-container h2 {
            margin-bottom: 20px;
            color: var(--accent);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .comment-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .comment-container textarea {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            width: 100%;
            box-sizing: border-box;
            resize: vertical;
            background: rgba(255,255,255,0.05);
            color: var(--text);
            font-family: inherit;
            min-height: 80px;
        }

        .comment-container textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }

        .comment-container input[type="submit"] {
            background: linear-gradient(180deg, var(--accent), var(--accent-2));
            color: #042027;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(6,182,212,0.12);
            transition: transform 0.12s ease, box-shadow 0.12s ease;
            font-size: 14px;
        }

        .comment-container input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6,182,212,0.16);
        }

        .comments {
            width: 100%;
            text-align: left;
        }

        .comments h3 {
            color: var(--accent);
            margin-bottom: 15px;
            text-align: center;
        }

        .comment {
            background: rgba(255,255,255,0.05);
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            word-wrap: break-word;
            color: var(--text);
            border-left: 3px solid var(--accent);
        }

        .no-comments {
            text-align: center;
            color: rgba(226, 232, 240, 0.6);
            font-style: italic;
            padding: 20px;
        }

        hr {
            border: none;
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 10px 0;
        }

        .hint {
            margin-top: 20px;
            padding: 10px;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 8px;
            color: #ffd700;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="comment-container">
        <h2>🎯 Public Comment Board</h2>
        
        <?php if (isset($error_msg)): ?>
            <div style="background: rgba(220, 20, 20, 0.1); color: #ff6b6b; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success_msg)): ?>
            <div style="background: rgba(20, 220, 20, 0.1); color: #51cf66; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <textarea name="comment" rows="4" placeholder="Share your thoughts..." required></textarea>
            <input type="submit" value="Post Comment">
        </form>

        <div class="comments">
            <h3>Recent Comments</h3>
            <?php 
            $hasComments = false;
            while ($r = $res->fetchArray(SQLITE3_ASSOC)): 
                $hasComments = true;
            ?>
                <div class="comment">
                    <?php echo $r['comment']; // Intentionally vulnerable to XSS ?>
                </div>
                <hr>
            <?php endwhile; ?>
            
            <?php if (!$hasComments): ?>
                <div class="no-comments">
                    No comments yet. Be the first to share your thoughts!
                </div>
            <?php endif; ?>
        </div>

        <div class="hint">
            💡 CTF Hint: Try testing for client-side vulnerabilities...
        </div>
    </div>
</body>
</html>