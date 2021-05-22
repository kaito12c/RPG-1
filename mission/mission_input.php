<?php
session_start();
include("../functions.php");
check_session_id();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" type="text/css" media="screen">
  <title>RPG（ミッション提供の部屋）</title>
</head>

<body>
  <form action="../mission/mission_create.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend><?= $_SESSION['username'] ?>さんが課すミッション教えて下さい。</legend>
      <a href="../mission/mission_read.php">ミッション一覧画面</a>
      <div>
        ミッション提供者：<?= $_SESSION['username'] ?>さん
      </div>
      <div>
        image: <input type="file" name="upfile" accept="image/*" capture="camera">
      </div>
      <div>
        <h4>ミッションゴール：</h4><p>締切まで頑張ったら得られる成果を教えて下さい。</p>
        <input type="text" name="mission_goal">
      </div>
      <div>
        <h4>ミッション：</h4><p>ミッションプランを教えて下さい。（150文字以内）</p>
        <textarea name="mission" cols="50" rows="5" onKeyUp="countLength(value, 'textlength2');">
1日目〜
8日目〜
15日目〜
22日目〜
</textarea><p id="textlength2">0文字</p>
      </div>
      <div>
        締切：<input type="date" name="deadline">
      </div>
      <div>
        <button>挑戦求ム</button>
      </div>
    </fieldset>
  </form>
  <script>
            function countLength(text, field) {
                document.getElementById(field).innerHTML = text.length + "文字";
                let sizeLimit=150;
                if (text.length >= sizeLimit) {
                    document.getElementById(field).style.color="#FF0000";
                    document.getElementById(field).innerHTML = text.length + `文字以上で${sizeLimit}を超えています`
                }else{
                    document.getElementById(field).style.color="#000000";
                    document.getElementById(field).innerHTML = text.length + "文字です。";
                }
            }
  </script>

</body>

</html>