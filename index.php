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
      background: #3498db url('image.webp') center/cover;
      color: white;
      text-align: center;
      padding: 3rem 20px;
      position: relative;
    }
    
    .banner::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(52, 152, 219, 0.7);
    }
    
    .banner h2, .banner p {
      position: relative;
      z-index: 1;
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
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-top: 2rem;
    }
    
    .blog-posts {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 40px;
    }
    
    .blog-card {
      background: white;
      border: 1px solid #ddd;
      border-radius: 5px;
      overflow: hidden;
    }
    
    .blog-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    
    .blog-content {
      padding: 20px;
    }
    
    .blog-content h3 {
      color: #2c3e50;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }
    
    .blog-meta {
      color: #999;
      font-size: 0.85rem;
      margin-bottom: 10px;
    }
    
    .blog-content p {
      color: #666;
      line-height: 1.6;
      margin-bottom: 15px;
    }
    
    .blog-content a {
      display: inline-block;
      background: #3498db;
      color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 3px;
      font-size: 0.9rem;
    }
    
    .blog-content a:hover {
      background: #2980b9;
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
    <h2 style="margin-bottom: 20px; color: #2c3e50;">Recent Blog Posts</h2>
    <div class="blog-posts">
      <div class="blog-card">
        <img src="b1.png" alt="Blog post">
        <div class="blog-content">
          <h3>Understanding Modern Web Security</h3>
          <p class="blog-meta">By Sarah Johnson • March 15, 2024</p>
          <p>Learn about the latest security practices and how to protect your web applications from common vulnerabilities.</p>
          <a href="#">Read More</a>
        </div>
      </div>

      <div class="blog-card">
        <img src="b2.webp" alt="Blog post">
        <div class="blog-content">
          <h3>Database Optimization Tips</h3>
          <p class="blog-meta">By Michael Chen • March 12, 2024</p>
          <p>Discover techniques to improve your database performance and handle large-scale data efficiently.</p>
          <a href="#">Read More</a>
        </div>
      </div>

      <div class="blog-card">
        <img src="b3.png" alt="Blog post">
        <div class="blog-content">
          <h3>Frontend Development Trends 2024</h3>
          <p class="blog-meta">By Emily Rodriguez • March 10, 2024</p>
          <p>Explore the latest trends in frontend development and what technologies are shaping the future of web design.</p>
          <a href="#">Read More</a>
        </div>
      </div>
    </div>

    <h2 style="margin: 40px 0 20px 0; color: #2c3e50;">Quick Links</h2>
    <div class="boxes">
      <div class="box">
        <h3>Browse Authors</h3>
        <p>Search and find authors who write about topics you're interested in.</p>
        <a href="sqli.php">View Authors</a>
      </div>

      <div class="box">
        <h3>Discussion Board</h3>
        <p>Join the conversation and share your thoughts about tech trends.</p>
        <a href="xss.php">Read Comments</a>
      </div>

      <div class="box">
        <h3>User Profile</h3>
        <p>View and manage your profile information and preferences.</p>
        <a href="idor.php?user=1">My Profile</a>
      </div>

      <div class="box">
        <h3>Profile Picture</h3>
        <p>Upload a profile picture to personalize your account.</p>
        <a href="upload.php">Upload Photo</a>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; TechBlog. WS - Yasith Liyanage.</p>
  </div>
</body>
</html>