<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Create_Thread();

$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Create_Thread</title>
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
          <h2>新規スレッド</h2>
        </div>
        <div class="window_content">
          <input class="button" type="button" onclick="location.href='./index.php'" name="" value="スレッド一覧へ">
          <form class="postform" action=""   method="post" id="postform">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            <input type="hidden" name="createdby" value="<?= h($app->me()->id); ?>">
            <h3>タイトル</h3>
            <input type="text" name="title" id="title"   value="">
            <p class="err"><?= h($app->getErrors('title')); ?></p>
            <h3>本文</h3>
            <textarea class="" name="content" id="content" rows="8" cols="80"></textarea>
            <br>
            <p class="err"><?= h($app->getErrors('write')); ?></p>
            <div class="button_submit" onclick="document.getElementById('postform').submit();">作成</div>
            <div class="button_submit" onclick="document.getElementById('postform').reset();">リセット</div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
