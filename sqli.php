<?php
$db = new SQLite3('data.db');
$q = isset($_GET['q']) ? $_GET['q'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>TechBlog - Search Authors</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      color: #333;
    }
    
    .header {
      background: #2c3e50;
      color: white;
      padding: 1rem 0;
      border-bottom: 3px solid #3498db;
    }
    
    .header .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .header h1 {
      font-size: 1.8rem;
    }
    
    .header nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
    }
    
    .header nav a:hover {
      color: #3498db;
    }
    
    .content {
      max-width: 800px;
      margin: 2rem auto;
      padding: 0 20px;
    }
    
    .search-box {
      background: white;
      padding: 30px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    
    .search-box h2 {
      color: #2c3e50;
      margin-bottom: 20px;
    }
    
    .search-box form {
      display: flex;
      gap: 10px;
    }
    
    .search-box input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 3px;
      font-size: 14px;
    }
    
    .search-box input[type="submit"] {
      background: #3498db;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    
    .search-box input[type="submit"]:hover {
      background: #2980b9;
    }
    
    .results {
      background: white;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .results h3 {
      color: #2c3e50;
      margin-bottom: 15px;
    }
    
    .results ul {
      list-style: none;
    }
    
    .results li {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .results li:last-child {
      border-bottom: none;
    }
    
    .results b {
      color: #2c3e50;
    }
    
    .no-results {
      color: #666;
      text-align: center;
      padding: 20px;
    }
    
    .footer {
      background: #2c3e50;
      color: white;
      text-align: center;
      padding: 1.5rem;
      margin-top: 3rem;
    }
    
    @media (max-width: 768px) {
      .header .container {
        flex-direction: column;
      }
      .header nav {
        margin-top: 10px;
      }
      .search-box form {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
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

  <div class="content">
    <div class="search-box">
      <h2>Search Authors</h2>
      <form method="get">
        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Enter author name...">
        <input type="submit" value="Search">
      </form>
    </div>

    <?php if ($q !== ''): ?>
      <div class="results">
        <h3>Search Results</h3>
        <ul>
          <?php
          // intentionally vulnerable (no parameterized query)
          $sql = "SELECT id, username, bio FROM users WHERE username LIKE '%$q%'";
          $res = $db->query($sql);
          $found = false;
          while ($row = $res->fetchArray(SQLITE3_ASSOC)): 
            $found = true;
          ?>
            <li><b><?php echo htmlspecialchars($row['username']); ?></b> - <?php echo htmlspecialchars($row['bio']); ?></li>
          <?php endwhile; ?>
          
          <?php if (!$found): ?>
            <li class="no-results">No authors found matching your search.</li>
          <?php endif; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>

  <div class="footer">
    <p>&copy; 2025 TechBlog - Web Security. Yasith Liyanage.</p>
  </div>
</body>
</html>