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
<h2>Upload avatar (allowed types: image/*)</h2>
<form method='post' enctype='multipart/form-data'>
<input type='file' name='avatar'>
<input type='submit' value='Upload'>
</form>
