
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RPGログイン画面</title>
</head>

<body>
  <h2>RPG-Real Playing Game-</h2>
  <h3>今度は、自分の人生をゲームしよう。</h3>
  <form action="dojo_login_act.php" method="post">
    <fieldset>
      <legend>RPGログイン画面</legend>
      <div>
        Name: <input type="text" name="username">
      </div>
      <div>
        Password: <input type="text" name="password">
      </div>
      <div>
        <button>ログイン</button>
      </div>
      <a href="dojo_register.php">登録する？</a>
    </fieldset>
  </form>

</body>

</html>
