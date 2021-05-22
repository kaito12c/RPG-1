<?php
session_start();
include("../functions.php");
check_session_id();

$id =$_POST['id'];
$name = $_POST['name'];
$mission_goal = $_POST['mission_goal'];
$mission = $_POST['mission'];
$deadline = $_POST['deadline'];
$pdo = connect_to_db();


 // idを指定して更新するSQLを作成(UPDATE文)
$sql = "UPDATE mission_table SET name=:name, mission=:mission, mission_goal=:mission_goal, deadline=:deadline, created_at=sysdate(), updated_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //数値だった場合、INT(INTEGER:整数)
$stmt->bindValue(':mission', $mission, PDO::PARAM_STR);
$stmt->bindValue(':mission_goal', $mission_goal, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR); 

$status = $stmt->execute();

 // 各値をpostで受け取る
 if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
    } else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する 
    header("Location:../mission/mission_read.php");
    exit();
    }