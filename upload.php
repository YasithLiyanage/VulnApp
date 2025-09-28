<?php
$upload_dir = __DIR__ . '/uploads';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $f = $_FILES['avatar'];
    if ($f['error'] === 0) {
        $target = $upload_dir . '/' . basename($f['name']);
        // intentionally no MIME/type validation -> vulnerable
        move_uploaded_file($f['tmp_name'], $target);
        echo "Uploaded to uploads/" . htmlspecialchars(basename($f['name']));
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>VulnApp — Upload</title>
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
    .upload-container {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255,255,255,0.03);
      text-align: center;
      width: 300px;
    }
    .upload-container h2 {
      margin-bottom: 20px;
      color: var(--accent);
    }
    .upload-container form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .upload-container input[type="file"] {
      margin-bottom: 10px;
    }
    .upload-container input[type="submit"] {
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
    .upload-container input[type="submit"]:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(6,182,212,0.16);
    }
    .hint {
      margin-top: 20px;
      color: var(--muted);
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="upload-container">
    <h2>Upload avatar (allowed types: image/*)</h2>
    <form method='post' enctype='multipart/form-data'>
      <input type='file' name='avatar'>
      <input type='submit' value='Upload'>
    </form>
    <div class="hint">
      Hint: Look in the parent folders for flag4.txt.
    </div>
  </div>
</body>
</html>