<?php
session_start();
include("../functions.php");
check_session_id();

// 送信されたidをgetで受け取る 
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
// idをgetで受け取る 
$id = $_GET['id'];

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM mission_table WHERE id=:id';
$stmt = $pdo->prepare($sql); 
$stmt->bindValue(':id', $id, PDO::PARAM_STR); 
$status = $stmt->execute();
// 一覧画面にリダイレクト 
header('Location:mission_read.php');


if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $record = $stmt->fetch(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  }
  
