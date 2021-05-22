<?php
session_start();
include("../functions.php");
check_session_id();

// 送信されたidをgetで受け取る 
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM mission_table WHERE id=:id'; 
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
  <title>Challenge Edit（編集画面）</title>
</head>

<body>
  <div><h2>編集画面</h2></div>
  <form action="../mission/mission_update.php" method="post">
    <fieldset>
      <legend><?= $_SESSION['username'] ?>さんが課すミッション教えて下さい。</legend>
      <a href="../mission/mission_read.php">一覧画面</a>
      <input type="hidden" name="id" value="<?=$record['id']?>">
      <div>
        ミッション提供者：<input type="text" name="name" value="<?=$record['name'] ?>">
      </div>
      <div>
        <h4>ミッションゴール：</h4><p>締切まで頑張った成果を教えて下さい。</p>
        <input type="text" name="mission_goal" value="<?=$record['mission_goal'] ?>">
      </div>
      <div>
        <h4>ミッション：</h4><p>ミッションプランを教えて下さい。</p>
        <textarea name="mission" cols="50" rows="5" value="<?=$record['mission'] ?>">
1日目〜
8日目〜
15日目〜
22日目〜
        </textarea>
      </div>
      <div>
        締切：<input type="date" name="deadline" value="<?=$record['deadline'] ?>">
      </div>
      <div>
        <button>挑戦求ム</button>
      </div>
    </fieldset>
  </form>

</body>

</html>