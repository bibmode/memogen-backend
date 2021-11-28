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

if (!isset($data->memo_id)) {
  echo json_encode(['success' => 0, 'message' => 'Please provide the note ID.', 'memoId' => $data->memo_id]);
  exit;
}

try {
  $fetch_post = "SELECT * FROM `memos` WHERE memo_id=:memo_id";
  $fetch_stmt = $conn->prepare($fetch_post);
  $fetch_stmt->bindValue(':memo_id', $data->memo_id, PDO::PARAM_INT);
  $fetch_stmt->execute();

  if ($fetch_stmt->rowCount() > 0) :

    $row = $fetch_stmt->fetch(PDO::FETCH_ASSOC);
    $post_title = isset($data->title) ? $data->title : $row['title'];
    $post_content = isset($data->content) ? $data->content : $row['content'];
    $post_motif = isset($data->motif) ? $data->motif : $row['motif'];
    $post_date = isset($data->date) ? $data->date : $row['date'];
    $post_user = isset($data->user_id) ? $data->user_id : $row['user_id'];

    $update_query = "UPDATE `memos` SET title = :title, content = :content, motif = :motif, date = :date, user_id = :user_id
        WHERE memo_id = :memo_id";

    $update_stmt = $conn->prepare($update_query);

    $update_stmt->bindValue(':title', htmlspecialchars(strip_tags($post_title)), PDO::PARAM_STR);
    $update_stmt->bindValue(':content', htmlspecialchars(strip_tags($post_content)), PDO::PARAM_STR);
    $update_stmt->bindValue(':motif', htmlspecialchars(strip_tags($post_motif)), PDO::PARAM_STR);
    $update_stmt->bindValue(':date', htmlspecialchars(strip_tags($post_date)), PDO::PARAM_STR);
    $update_stmt->bindValue(':user_id', $data->user_id, PDO::PARAM_INT);
    $update_stmt->bindValue(':memo_id', $data->memo_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {

      echo json_encode([
        'success' => 1,
        'message' => 'Post updated successfully'
      ]);
      exit;
    }

    echo json_encode([
      'success' => 0,
      'message' => 'Post Not updated. Something is going wrong.'
    ]);
    exit;

  else :
    echo json_encode(['success' => 0, 'message' => 'Invalid ID. No posts found by the ID.']);
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
