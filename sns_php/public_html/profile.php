<?php

// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

$user_id = $_GET['user_id'];
$app = new MyApp\Controller\Profile();
$app->run($user_id);
$user = $app->getValues()->user;






?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Profile</title>
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
          <h2>プロフィール</h2>
        </div>
        <div class="window_content">
          <form  id="postform">
            <img src="../picture/icon/<?=$user['icon']; ?>" style="margin:0; border:2px black solid; width:50px; height:50px; display:inline-block;">
            <?= $user['username'] ?><br>
            <?= $user['email']?><br>
            <?= $user['created']?><br>


            <br>
            <p class="err"><?= h($app->getErrors('icon')); ?></p>
            <p class="err"><?= h($app->getErrors('write')); ?></p>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
