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
  <link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="menu.js"></script>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <div class="header_title">
          <a href="index.php"><h3>掲示板</h3></a>
      </div>
      <div class="header_userinfo">
        <div class="header_userinfo_icon">
          <img src="../picture/icon/<?=h($app->me()->icon); ?>">
        </div>
        <nav class="menu_container">
          <ul class="menu">
            <div class="menu_userinfo">
              <div class="menu_userinfo_icon">
                <img src="../picture/icon/<?=h($app->me()->icon); ?>">
              </div>
              <div class="menu_userinfo_text">
                <p>
                  <?= h($app->me()->username) ?>
                  <?= h($app->me()->email) ?>
                </p>
              </div>
            </div>
            <li class="menu_item">
              <a href="edit.php">
                <div class="menu_item_block">
                  プロフィール編集
                </div>
              </a>
            </li>
            <li class="menu_item">
              <a href="">
                <div class="menu_item_block">
                  メッセージ
                </div>
              </a>
            </li>
            <li class="menu_item">
              <a href="">
                <div class="menu_item_block">
                  メニュー
                </div>
              </a>
            </li>
            <li class="menu_item">
              <div class="menu_item_block" onclick="document.getElementById('logout').submit();" style="cursor:pointer;">
                <form action="logout.php" method="post" id="logout" style="display:inline-block;">
                  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                  ログアウト
                </form>
              </div>
            </li>
          </ul>
        </nav>
      </div>
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
