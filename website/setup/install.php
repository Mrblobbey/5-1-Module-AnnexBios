<?php
// link naar de database 
require_once __DIR__ . '/../includes/db.php';

$sqlPath = __DIR__ . '/database.sql';
$sql = file_get_contents($sqlPath);
if ($sql === false) {
  exit('Kon database.sql niet lezen');
}

// Eenvoudige splitter: werkt prima als je dump geen DELIMITER-trucs gebruikt
$stmts = array_filter(array_map('trim', explode(";", $sql)));

try {
  $pdo->beginTransaction();
  foreach ($stmts as $stmt) {
    if ($stmt !== '') {
      $pdo->exec($stmt);
    }
  }
  $pdo->commit();
  echo "Database is geïnstalleerd.";
} catch (Throwable $e) {
  $pdo->rollBack();
  echo "Fout bij installeren: " . htmlspecialchars($e->getMessage());
}