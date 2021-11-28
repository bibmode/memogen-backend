<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();
$email = null;

if (isset($_GET['email'])) {
  $email = $_GET['email'];
}

try {
  $sql = "SELECT `id` FROM `users` WHERE email='$email'";

  $stmt = $conn->prepare($sql);

  $stmt->execute();

  if ($stmt->rowCount() > 0) :
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

  else :
    echo json_encode([
      'success' => 0,
      'message' => 'No Result Found!',
      'stmt' => $stmt->fetchAll(PDO::FETCH_ASSOC),
      'email' => $email
    ]);
  endif;
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage()
  ]);
  exit;
}
