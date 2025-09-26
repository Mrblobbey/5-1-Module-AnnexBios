<?php
// Simpele PDO-connector: om de db te verbinden 
$DB_HOST = 'localhost';   
$DB_NAME = 'annexbiosma_maarssen';
$DB_USER = 'annexbiosma_maarssen';       
$DB_PASS = 'iFS3cSfVzp'; 

// $DB_HOST = 'localhost';   
// $DB_NAME = 'annexbios_maarssen';
// $DB_USER = 'root';       
// $DB_PASS = ''; 


try {
    $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
// controleert of de verbinden gelukt is anders stopt hij en geeft fout melding 
  http_response_code(500);
  exit('DB-verbinding mislukt');
}
?>
