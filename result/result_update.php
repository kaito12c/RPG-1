<?php



session_start();
include("../functions.php");
check_session_id();

$id =$_POST['id'];
$name =$_POST['name'];
$result = $_POST['result'];
$think = $_POST['think'];
$pdo = connect_to_db();




 // idを指定して更新するSQLを作成(UPDATE文)
$sql = "UPDATE result_table SET name=:name, result=:result, think=:think, done_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':result', $result, PDO::PARAM_STR);
$stmt->bindValue(':think', $think, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($_POST);
// exit();

 // 各値をpostで受け取る
 if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
    } else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する 
    header("Location:result_input.php");
    exit();
    }