<?php

// 新規登録

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/style_pc.css" media="screen and (min-width: 960px)">
  <link rel="stylesheet" href="css/style_tab.css" media="screen and (max-width: 960px)">
  <link rel="stylesheet" href="css/style_sp.css" media="screen and (max-width: 600px)">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="menu.js"></script>
</head>
<body>
<div class="wrapper">
  <div id="container">
    <form action="" method="post" id="signup">
      <p>
        <input type="text" name="username" placeholder="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username) : ''; ?>">
      </p>
      <p class="err"><?= h($app->getErrors('username')); ?></p>
      <p>
        <input type="text" name="email" placeholder="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
      </p>
      <p class="err"><?= h($app->getErrors('email')); ?></p>
      <p>
        <input type="password" name="password" placeholder="password">
      </p>
      <p class="err"><?= h($app->getErrors('password')); ?></p>
      <div class="button_submit" onclick="document.getElementById('signup').submit();">Sign Up</div>
      <p class="button_submit"><a href="/public_html/login.php">Log In</a></p>
      <!-- <input class="input" type="submit" name="SUBMIT" value="投稿"> -->
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div>
</div>
</body>
</html>
