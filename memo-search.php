<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();
$user_id = null;
$search_input = null;

if (isset($_GET['id']) && isset($_GET['search'])) {
  $user_id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
    'options' => [
      'default' => 'all_posts',
      'min_range' => 1
    ]
  ]);

  $search_input = $_GET['search'];
}

try {
  $sql = "SELECT * FROM `memos` WHERE user_id='$user_id' AND (title LIKE '%$search_input%' OR content LIKE '%$search_input%')";

  $stmt = $conn->prepare($sql);

  $stmt->execute();

  if ($stmt->rowCount() > 0) :
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

  else :
    echo json_encode([
      'success' => 0,
      'message' => 'No Result Found!',
      'id' => $user_id,
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
