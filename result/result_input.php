<?php
session_start();
include("../functions.php");
check_session_id();

$id = $_GET['id'];
$name =$_POST['name'];
$result = $_POST['result'];
$think = $_POST['think'];

// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM result_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// バインド変数に格納（セキュリティ） 
$status = $stmt->execute(); // SQLを実行

if ($status==false) {
  $error = $stmt->errorInfo();
  exit('sqlError:'.$error[2]);
 } else {

  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//   while($result = $stmt -> fetch(PDO::FETCH_ASSOC)){
//     $view .= $result["id"]."-".$result;
// }
  $output = "";
  foreach ($result as $record) {
    if($id == $record['id']){ 
      $output .= "<tr>";   
      $output .= "<td>{$record["done_at"]}</td>";
      $output .= "<td>{$record["name"]}</td>";
      $output .= "<td>{$record["result"]}</td>";
      $output .= "<td>{$record["think"]}</td>";
      if($record["name"] == $_SESSION['username']){ 
      $output .= "<td><a href='result_edit.php?id={$record["id"]}'>編集</a></td>";
      $output .= "<td><a href='result_delete.php?id={$record["id"]}'>削除</a></td>";
      }
      $output .= "</tr>";
      };

  } 

  unset($record);
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RPG（ミッション実行の部屋）</title>
</head>

<body>
  <form action="../result/result_create.php" method="post">
    <fieldset>
      <legend>あなたが挑んだミッション結果</legend>
      <a href="../mission/mission_read.php">挑戦一覧画面</a>
      <div>
        名前：<?= $_SESSION['username'] ?>さん
      </div>
      <div>
        ミッション実行結果<input type="text" name="result">
      </div>
      <div>
        ミッションやってみた感想<input type="text" name="think">
      </div>
      <div>
        <button>挑戦しました。</button>
      </div>
    </fieldset>
  </form>
  <fieldset>
    <legend>ミッション一覧</legend>
    <a href="../mission/mission_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>実行日付</th>
          <th>名前</th>
          <th>実行結果</th>
          <th>ミッションしてみての感想</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?> 
      </tbody>
    </table>
  </fieldset>
  <a href='../login/dojo_logout.php'>Logout</a>
</body>

</html>