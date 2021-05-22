<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RPG入会画面</title>
</head>

<body>
  <form action="dojo_c_register_act.php" method="POST">
    <fieldset>
      <legend>登録はこちら</legend>
      <div>
        Name: <input type="text" name="ch_usn">
      </div>
      <div>
        Password: <input type="text" name="password">
      </div>
        <button>自分の人生をゲームしますか？</button>

      <a href="dojo_login.php">or Login</a>
    </fieldset>
  </form>
</body>

</html>