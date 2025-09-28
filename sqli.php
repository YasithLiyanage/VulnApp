<?php
$db = new SQLite3('data.db');

$q = isset($_GET['q']) ? $_GET['q'] : '';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>VulnApp — Search Users</title>
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
    .search-container {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255,255,255,0.03);
      text-align: center;
      width: 300px;
    }
    .search-container h2 {
      margin-bottom: 20px;
      color: var(--accent);
    }
    .search-container form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .search-container input[type="text"] {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 10px;
      width: 100%;
      box-sizing: border-box;
    }
    .search-container input[type="submit"] {
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
    .search-container input[type="submit"]:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(6,182,212,0.16);
    }
    .hint {
      margin-top: 20px;
      color: var(--muted);
      font-size: 14px;
    }
    ul {
      list-style-type: none;
      padding: 0;
      margin: 20px 0 0 0;
      width: 100%;
    }
    li {
      background: rgba(255,255,255,0.05);
      margin: 5px 0;
      padding: 10px;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="search-container">
    <h2>Search Users</h2>
    <form method='get'>
      <input type='text' name='q' value='<?php echo htmlspecialchars($q); ?>'>
      <input type='submit' value='Search'>
    </form>
    <div class="hint">
      Hint: Look for flag1.
    </div>
    <?php if ($q !== ''): ?>
      <ul>
        <?php
        // intentionally vulnerable (no parameterized query)
        $sql = "SELECT id, username, bio FROM users WHERE username LIKE '%$q%'";
        $res = $db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)): ?>
          <li><b><?php echo htmlspecialchars($row['username']); ?></b> - <?php echo htmlspecialchars($row['bio']); ?></li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>
  </div>
</body>
</html>