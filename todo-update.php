<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->todo_id)) {
  echo json_encode(['success' => 0, 'message' => 'Please provide the note ID.', 'todoId' => $data->todo_id]);
  exit;
}

try {
  $fetch_post = "SELECT * FROM `todos` WHERE todo_id=:todo_id";
  $fetch_stmt = $conn->prepare($fetch_post);
  $fetch_stmt->bindValue(':todo_id', $data->todo_id, PDO::PARAM_INT);
  $fetch_stmt->execute();

  if ($fetch_stmt->rowCount() > 0) :

    $row = $fetch_stmt->fetch(PDO::FETCH_ASSOC);
    $post_content = isset($data->content) ? $data->content : $row['content'];
    $post_status = isset($data->status) ? $data->status : $row['status'];
    $post_user = isset($data->user_id) ? $data->user_id : $row['user_id'];

    $update_query = "UPDATE `todos` SET content = :content, status = :status, user_id = :user_id
        WHERE todo_id = :todo_id";

    $update_stmt = $conn->prepare($update_query);

    $update_stmt->bindValue(':content', htmlspecialchars(strip_tags($post_content)), PDO::PARAM_STR);
    $update_stmt->bindValue(':status', htmlspecialchars(strip_tags($post_status)), PDO::PARAM_STR);
    $update_stmt->bindValue(':user_id', $data->user_id, PDO::PARAM_INT);
    $update_stmt->bindValue(':todo_id', $data->todo_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {

      echo json_encode([
        'success' => 1,
        'message' => 'todos updated successfully'
      ]);
      exit;
    }

    echo json_encode([
      'success' => 0,
      'message' => 'todos Not updated. Something is going wrong.'
    ]);
    exit;

  else :
    echo json_encode(['success' => 0, 'message' => 'Invalid ID. No todos found by the ID.']);
    exit;
  endif;
} catch (PDOException $e) {
  // http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage(),
    'data' => $fetch_stmt
  ]);
  exit;
}
