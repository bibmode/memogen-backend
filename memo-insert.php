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

if (!isset($data->title) || !isset($data->content)) :
  echo json_encode([
    'success' => 0,
    'message' => 'Please fill all the fields | title and note content.',
  ]);
  exit;

elseif (empty(trim($data->title)) || empty(trim($data->content))) :
  echo json_encode([
    'success' => 0,
    'message' => 'Oops! empty field detected. Please fill all the fields.',
  ]);
  exit;

endif;

try {

  $title = htmlspecialchars(trim($data->title));
  $content = htmlspecialchars(trim($data->content));
  $date = htmlspecialchars(trim($data->date));
  $motif = htmlspecialchars(trim($data->motif));
  $user = htmlspecialchars(trim($data->user));

  $query = "INSERT INTO `memos`(title,content,date, motif, user_id) VALUES(:title,:content,:date, :motif, :user)";

  $stmt = $conn->prepare($query);

  $stmt->bindValue(':title', $title, PDO::PARAM_STR);
  $stmt->bindValue(':content', $content, PDO::PARAM_STR);
  $stmt->bindValue(':date', $date, PDO::PARAM_STR);
  $stmt->bindValue(':motif', $motif, PDO::PARAM_STR);
  $stmt->bindValue(':user', $user, PDO::PARAM_INT);

  if ($stmt->execute()) {
    http_response_code(201);

    $query2 =
      "SELECT * FROM `memos` WHERE user_id='$user'";

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
