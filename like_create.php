<?php



session_start();
include("functions.php");
check_session_id();

$user_id = $_GET['user_id'];
$mission_id = $_GET['mission_id'];

$pdo = connect_to_db();


// $sql = 'INSERT INTO like_table(id, user_id, mission_id, created_at) VALUES(NULL, :user_id, :mission_id, sysdate())';
$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND mission_id=:mission_id';
 // SQL作成
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':mission_id', $mission_id, PDO::PARAM_INT);
$status = $stmt->execute();

// var_dump($_GET);
// exit();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
// エラー処理 
} else {
  $like_count = $stmt -> fetch();
  if ($like_count[0] != 0) {
    $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND mission_id=:mission_id';
  } else {
    $sql = 'INSERT INTO like_table(id, user_id, mission_id, created_at)VALUES(NULL, :user_id, :mission_id, sysdate())';
  }
}
// var_dump($like_count[0]);
// exit();


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':mission_id', $mission_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
// エラー処理 
} else {
  header("Location:mission/mission_read.php");
}