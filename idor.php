<?php
$db = new SQLite3('data.db');
$id = isset($_GET['user']) ? intval($_GET['user']) : 0;
$row = $db->querySingle("SELECT id, username, email, secret_note FROM users WHERE id = $id", true);
if (!$row) {
    echo "User not found";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>TechBlog - User Profile</title>
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
    
    .profile-box {
      background: white;
      padding: 30px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .profile-box h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid #3498db;
    }
    
    .profile-info {
      margin: 20px 0;
    }
    
    .profile-info label {
      display: block;
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 5px;
      font-weight: bold;
    }
    
    .profile-info p {
      color: #333;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 3px;
      border-left: 3px solid #3498db;
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
    <div class="profile-box">
      <h2>User Profile</h2>
      
      <div class="profile-info">
        <label>Username</label>
        <p><?php echo htmlspecialchars($row['username']); ?></p>
      </div>
      
      <div class="profile-info">
        <label>Email Address</label>
        <p><?php echo htmlspecialchars($row['email']); ?></p>
      </div>
      
      <div class="profile-info">
        <label>Personal Note</label>
        <p><?php echo htmlspecialchars($row['secret_note']); ?></p>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; 2025 TechBlog - Web Security. Yasith Liyanage.</p>
  </div>
</body>
</html>