<?php
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>VulnApp — Yasith Liyanage</title>
  <link rel="stylesheet" href="style.css">
  <style>
    :root{--bg:#071224;--card:rgba(255,255,255,0.03);--accent:#6be3ff;--text:#cfeff6}
    body{margin:0;background:linear-gradient(180deg,#071224,#06111a);color:var(--text);font-family:Inter,system-ui,Arial,Helvetica,sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}
    .wrap{max-width:900px;width:100%}
    header{margin-bottom:20px;text-align:center}
    h1{margin:0;font-size:28px;color:var(--accent)}
    .subtitle{margin:6px 0 0;color:rgba(207,239,246,0.85)}
    .main-grid{display:grid;grid-template-columns:1fr;gap:18px}
    .card{background:var(--card);padding:18px;border-radius:10px;border:1px solid rgba(255,255,255,0.03)}
    .lead{margin:0 0 12px 0;color:rgba(207,239,246,0.9)}
    .links{display:flex;flex-direction:column;gap:8px}
    .btn{display:inline-block;padding:10px 14px;border-radius:8px;text-decoration:none;background:linear-gradient(180deg,var(--accent),#39c0d9);color:#042027;font-weight:600}
    footer{margin-top:14px;text-align:center;font-size:13px;color:rgba(207,239,246,0.7)}
    @media(min-width:700px){ .main-grid{grid-template-columns:1fr 320px} .links{flex-direction:column} }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <h1>VulnApp <span style="font-weight:400">— IE2062 Web Security</span></h1>
      <p class="subtitle">A deliberately vulnerable web application — Yasith Liyanage</p>
    </header>

    <main class="main-grid">
      <section class="card">
        <h2 style="margin-top:0">Start the Lab</h2>
        <p class="lead">Choose a challenge below.</p>
        <nav class="links" aria-label="lab links">
          <a class="btn" href="sqli.php">Search users (SQLi)</a>
          <a class="btn" href="xss.php">Comment board (XSS)</a>
          <a class="btn" href="idor.php?user=1">View profile (IDOR)</a>
          <a class="btn" href="upload.php">Upload avatar (File upload)</a>
        </nav>
      </section>

      <aside class="card" style="display:flex;align-items:center;justify-content:center">
        <div style="text-align:center">
          <strong>OWASP Mapping</strong>
          <ul style="list-style:none;padding:0;margin:8px 0 0 0;color:rgba(207,239,246,0.9)">
            <li>SQLi — Injection</li>
            <li>XSS — Cross-Site Scripting</li>
            <li>IDOR — Broken Access Control</li>
            <li>Upload — Misconfiguration / RCE risk</li>
          </ul>
        </div>
      </aside>
    </main>

    <footer>
      <small>Web Security lab — Yasith Liyanage</small>
    </footer>
  </div>
</body>
</html>
