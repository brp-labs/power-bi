<?php
  // Author: Brian Ravn Pedersen
  // GitHub Repo: power-bi

  // API til Power BI-integration med cloud-hostet MySQL-database.
  
  require_once 'config.php'; // Henter den gyldige API-KEY (config.php er adgangsbeskyttet via .htaccess)
  require_once 'databaseoplysninger.php'; // Henter host, username, password, dbname, tabel. Er ligeledes adgangsbeskyttet.

  $received_key = $_GET['key'] ?? '';

  if ($received_key !== $api_key) {
      http_response_code(403);
      echo json_encode(["error" => "Ugyldig eller manglende API-KEY"]);
      exit;
  }

  try {
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  } catch (PDOException $e) {
      http_response_code(500);
      echo json_encode(["error" => "Databaseforbindelsen fejlede"]);
      exit;
  }

  $stmt = $pdo->query("SELECT * FROM $tabel");
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: application/json');
  echo json_encode($data);

?>


