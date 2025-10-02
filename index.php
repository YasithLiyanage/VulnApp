<?php
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>TechBlog - Home</title>
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
    
    .banner {
      background: #3498db;
      color: white;
      text-align: center;
      padding: 3rem 20px;
    }
    
    .banner h2 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }
    
    .content {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 20px;
    }
    
    .boxes {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 2rem;
    }
    
    .box {
      background: white;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .box h3 {
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .box p {
      color: #666;
      line-height: 1.6;
      margin-bottom: 15px;
    }
    
    .box a {
      display: inline-block;
      background: #3498db;
      color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 3px;
    }
    
    .box a:hover {
      background: #2980b9;
    }
    
    .footer {
      background: #2c3e50;
      color: white;
      text-align: center;
      padding: 1.5rem;
      margin-top: 3rem;
    }
    
    @media (max-width: 768px) {
      .boxes {
        grid-template-columns: 1fr;
      }
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

  <div class="banner">
    <h2>Welcome to TechBlog</h2>
    <p>Your source for technology news and articles</p>
  </div>

  <div class="content">
    <div class="boxes">
      <div class="box">
        <h3>Browse Authors</h3>
        <p>Search and find authors who write about topics you're interested in. Connect with writers from around the world.</p>
        <a href="sqli.php">View Authors</a>
      </div>

      <div class="box">
        <h3>Discussion Board</h3>
        <p>Join the conversation and share your thoughts. Read what others are saying about the latest tech trends.</p>
        <a href="xss.php">Read Comments</a>
      </div>

      <div class="box">
        <h3>User Profile</h3>
        <p>View and manage your profile information. Update your details and preferences anytime.</p>
        <a href="idor.php?user=1">My Profile</a>
      </div>

      <div class="box">
        <h3>Profile Picture</h3>
        <p>Upload a profile picture to personalize your account. Show your personality with a custom avatar.</p>
        <a href="upload.php">Upload Photo</a>
      </div>

      <div class="box">
        <h3>Recent Posts</h3>
        <p>Check out the latest articles and blog posts from our community of writers and contributors.</p>
        <a href="#">Coming Soon</a>
      </div>

      <div class="box">
        <h3>About Us</h3>
        <p>Learn more about TechBlog and our mission to provide quality content for tech enthusiasts everywhere.</p>
        <a href="#">Learn More</a>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; 2025 TechBlog - Web Security. Yasith Liyanage.</p>
  </div>
</body>
</html>