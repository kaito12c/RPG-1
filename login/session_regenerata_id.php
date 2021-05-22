<?php
// sessionをスタートしてidを再生成しよう．
// 旧idと新idを表示しよう．

session_start();
$OLD_session_id = session_id();
session_regenerate_id(true);
$NEW_session_id = session_id();

echo "<p>{$OLD_session_id}</p>";
echo "<p>{$NEW_session_id}</p>";