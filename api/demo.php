<?php

if (isset($_POST['content'])) {
  $content = $_POST['content'];
  $response = array("success" => true, "message" => $content);

  echo json_encode($response);
}
