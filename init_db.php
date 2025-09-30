<?php
// Path to your SQLite database file
$dbPath = 'data.db';

// Read the SQL initialization file
$initSql = file_get_contents('data-init.sql');

// Create a new PDO instance
$db = new PDO("sqlite:$dbPath");

// Execute the SQL statements
$statements = explode(';', $initSql);
foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement)) {
        $db->exec($statement);
    }
}

echo "Database initialized successfully.";
?>