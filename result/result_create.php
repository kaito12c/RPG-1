<?php



session_start();
include("../functions.php");
check_session_id();

if(
  !isset($_SESSION['username']) || $_SESSION['username']=='' ||
  !isset($_POST['result']) || $_POST['result']=='' ||
  !isset($_POST['think']) || $_POST['think']==''
){
  exit('ParamError');
}

$name = $_SESSION['username'];
$result = $_POST['result'];
$think = $_POST['think'];

$pdo = connect_to_db();

$sql = 'INSERT INTO result_table(id, name, result, think, done_at) VALUES(NULL, :name, :result, :think, sysdate())';


$stmt = $pdo->prepare($sql);


// バインド変数に格納（セキュリティ）
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //数値だった場合、INT(INTEGER:整数)
$stmt->bindValue(':result', $result, PDO::PARAM_STR);
$stmt->bindValue(':think', $think, PDO::PARAM_STR); 
$status = $stmt->execute(); // SQLを実行




if ($status==false) {
  $error = $stmt->errorInfo(); // データ登録失敗次にエラーを表示 exit('sqlError:'.$error[2]);
  } else {
  // 登録ページへ移動
    header('Location:result_input.php');
  }
