<?php
session_start();
include("../functions.php");
check_session_id();

// 送信されたidをgetで受け取る 
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM result_table WHERE id=:id'; 
$stmt = $pdo->prepare($sql); 
$stmt->bindValue(':id', $id, PDO::PARAM_STR); 
$status = $stmt->execute();

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


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Challenge（編集画面）</title>
</head>

<body>
  <div><h2>編集画面</h2></div>
  <form action="result_update.php" method="POST">
    <fieldset>
      <legend>Challenge（編集画面）</legend>
      <a href="result_input.php">一覧画面</a>
      <!-- idを見えないように送る -->
      <!-- input type="hidden"を使用する! -->
      <!-- form内に以下を追加 -->
      <input type="hidden" name="id" value="<?=$record['id']?>">
      <!--更新のformは，登録と同じくpostで各値を送信しています! -->
      <div>
        Name<input type="text" name="name" value="<?=$record['name'] ?>">
      </div>
      <div>
        ミッション実行結果<input type="text" name="result" value="<?=$record['result'] ?>">
      </div>
      <div>
        ミッションやってみた感想<input type="text" name="think" value="<?=$record['think'] ?>">
      </div>
      <div>
        <button>Done</button>
      </div>

    </fieldset>
  </form>

</body>

</html>