<?php

// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Edit();
$app->run();





?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Edit</title>
  <link rel="stylesheet" href="css/style_pc.css" media="screen and (min-width: 960px)">
  <link rel="stylesheet" href="css/style_tab.css" media="screen and (max-width: 960px)">
  <link rel="stylesheet" href="css/style_sp.css" media="screen and (max-width: 600px)">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    $(function() {
      $("#header").load("header.php");
    });
  </script>
  <script type="text/javascript" src="menu.js"></script>
</head>
<body>
  <div class="wrapper">
    <div class="header" id="header">
    </div>

    <div class="container">
      <div class="window">
        <div class="window_title">
          <h2>登録内容の変更</h2>
        </div>
        <div class="window_content">
          <form action="" method="post" enctype="multipart/form-data" id="postform">
            <?=h($app->me()->username); ?><br>
            <?=h($app->me()->email); ?><br>
            <input type="hidden" name="id" value="<?= h($app->me()->id); ?>">
            <img src="../picture/icon/<?=h($app->me()->icon); ?>" style="margin:0; border:2px black solid; width:50px; height:50px; display:inline-block;">
            <input type="file" name="upload_file">
            <br>
            <div class="button_submit" onclick="document.getElementById('postform').submit();">アイコンを変更する</div>
            <p class="err"><?= h($app->getErrors('icon')); ?></p>
            <p class="err"><?= h($app->getErrors('write')); ?></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
