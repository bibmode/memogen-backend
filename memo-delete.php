<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
  echo json_encode(['success' => 0, 'message' => 'Please provide the memo ID.', 'id' => $data]);
  exit;
}

try {
  $fetch_post = "SELECT * FROM `memos` WHERE memo_id=:id";
  $fetch_stmt = $conn->prepare($fetch_post);
  $fetch_stmt->bindValue(':id', $data->id, PDO::PARAM_INT);
  $fetch_stmt->execute();

  if ($fetch_stmt->rowCount() > 0) :

    $delete_memo = "DELETE FROM `memos` WHERE memo_id=:id";
    $delete_memo_stmt = $conn->prepare($delete_memo);
    $delete_memo_stmt->bindValue(':id', $data->id, PDO::PARAM_INT);

    if ($delete_memo_stmt->execute()) {
      echo json_encode([
        'success' => 1,
        'message' => 'Post Deleted successfully'
      ]);
      exit;
    }

    echo json_encode([
      'success' => 0,
      'message' => 'Post Not Deleted. Something is going wrong.'
    ]);
    exit;

  else :
    echo json_encode(['success' => 0, 'message' => 'Invalid ID. No posts found by the ID.']);
    exit;
  endif;
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage()
  ]);
  exit;
}
