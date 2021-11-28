<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->content)) :
  echo json_encode([
    'success' => 0,
    'message' => 'Please add a content.',
  ]);
  exit;

elseif (empty(trim($data->content))) :
  echo json_encode([
    'success' => 0,
    'message' => 'Oops! empty field detected. Please fill all the fields.',
  ]);
  exit;

endif;

try {

  $content = htmlspecialchars(trim($data->content));
  $status = htmlspecialchars(trim($data->status));
  $user = htmlspecialchars(trim($data->user));

  $query = "INSERT INTO `todos`(content,status, user_id) VALUES(:content,:status, :user)";

  $stmt = $conn->prepare($query);

  $stmt->bindValue(':content', $content, PDO::PARAM_STR);
  $stmt->bindValue(':status', $status, PDO::PARAM_STR);
  $stmt->bindValue(':user', $user, PDO::PARAM_INT);

  if ($stmt->execute()) {
    http_response_code(201);

    $query2 =
      "SELECT * FROM `todos` WHERE user_id='$user'";

    $stmt2 = $conn->prepare($query2);
    $stmt2->execute();

    $data2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data2);
    exit;
  }

  echo json_encode([
    'success' => 0,
    'message' => 'Data not Inserted.'
  ]);
  exit;
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage()
  ]);
  exit;
}
