<?php
// index.php - Styled landing page for VulnApp
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>VulnApp — IE2062 Web Security Lab</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="wrap">
      <h1 class="brand">VulnApp <span class="muted">— IE2062 Web Security</span></h1>
      <p class="subtitle">A deliberately vulnerable web application for learning SQLi, XSS, IDOR, and file upload flaws. By Yasith Liyanage</p>
    </div>
  </header>

  <main class="wrap main-grid">
    <section class="card">
      <h2>Start the Lab</h2>
      <p class="lead">Pick a challenge below. Each page contains an intentional vulnerability mapped to OWASP Top 10.</p>
      <nav class="links">
        <a class="btn" href="sqli.php"> Search users (SQLi)</a>
        <a class="btn" href="xss.php"> Comment board (XSS)</a>
        <a class="btn" href="idor.php?user=1"> View profile (IDOR)</a>
        <a class="btn" href="upload.php"> Upload avatar (File upload)</a>
      </nav>
    </section>

    <aside class="card info">
      <h3>Quick Tips</h3>
      <ul>
        <li>Take screenshots for your walkthrough.</li>
        <li>Do not expose instructor flags publicly — keep offline.</li>
        <li>Use the <code>data-init.sql</code> file to recreate the DB if needed.</li>
      </ul>

      <h3>OWASP Mapping</h3>
      <ul>
        <li><strong>SQLi</strong> — Injection (A03)</li>
        <li><strong>XSS</strong> — Cross-Site Scripting (A07)</li>
        <li><strong>IDOR</strong> — Broken Access Control (A01)</li>
        <li><strong>Upload</strong> — Security Misconfiguration / RCE risk</li>
      </ul>
    </aside>

    <section class="card notes">
      <h3>How to use</h3>
      <ol>
        <li>Open each page and try the suggested payloads in the walkthrough.</li>
        <li>Capture PoC steps and store screenshots in <code>walkthrough/</code>.</li>
        <li>Create your report with findings, impact and mitigations.</li>
      </ol>
    </section>
  </main>

  <footer class="site-footer">
    <div class="wrap">
      <small>Created for IE2062 — Web Security lab • Do not expose flags publicly • Test in isolated environment</small>
    </div>
  </footer>
</body>
</html>
