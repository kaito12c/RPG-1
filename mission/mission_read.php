<?php



// DB接続情報(ローカルホスト)
session_start();
include("../functions.php");
check_session_id();

$user_id = $_SESSION['id'];

// DB接続
$pdo = connect_to_db();
$sql = 'SELECT * FROM mission_table LEFT OUTER JOIN (SELECT mission_id, COUNT(id) AS cnt FROM like_table GROUP BY mission_id) AS likes ON mission_table.id = likes.mission_id';
$stmt = $pdo->prepare($sql);
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
    $output .= "<tr>";
    $output .= "<td>{$record["id"]}</td>";
    $output .= "<td><img src='{$record["image"]}' height=150px></td>";
    $output .= "<td>{$record["name"]}</td>";
    $output .= "<td>{$record["deadline"]}までに</td>";
    $output .= "<td>{$record["mission_goal"]}</td>";
    $output .= "<td>{$record["mission"]}</td>";
    $output .= "<td><button> <a href='../result/result_input.php?id={$record["id"]}'>ミッションに挑戦</button></td>";
    $output .= "<td><a href='../like_create.php?user_id={$user_id}&mission_id={$record["id"]}'>{$record["cnt"]}いいね！</a></td>";
    if($record["name"] == $_SESSION['username']){ 
    $output .= "<td><a href='mission_edit.php?id={$record["id"]}'>編集</a></td>"; 
    $output .= "<td><a href='mission_delete.php?id={$record["id"]}'>削除</a></td>";
    };
    $output .= "</tr>";
  } 
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ミッション一覧</title>
</head>

<body>
  <fieldset>
    <legend>ミッション一覧</legend>
    <a href="mission_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
        <th>番号</th>
        <th>サムネイル</th>          
          <th>名前</th>
          <th>締切</th>
          <th>ミッションゴール</th>
          <th>ミッション内容</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?> 
      </tbody>
    </table>
  </fieldset>
  <a href='../login/dojo_logout.php'>Logout</a>
  <a href="../ajax_research.html">Search</a>

</body>

</html>