<?php

// var_dump($_GET);
// exit();
// session_start();
// check_session_id();
include("functions.php");

$search_Word = $_GET['searchWord'];

$pdo = connect_to_db();

 // 関数ファイル読み込み処理を記述(認証関連は省略でOK)
// DB接続の処理を記述
$sql = "SELECT * FROM mission_table WHERE mission LIKE '%{$search_word}%'";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// SQL実行の処理を記述
if ($status == false) {
// エラー処理を記述 
echo json_encode(["error_msg" => "{$error[2]}"]); 
} else {
// LIKEを使って検索
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result); 
// JSON形式にして出力 
exit();
}