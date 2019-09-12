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
</head>
<body>
    <div class="header">
      <a href="index.php" Align="center"><h3>掲示板</h3></a>
      <div Align="right">
        <a href ="edit.php">
        <img src="../picture/icon/<?=h($app->me()->icon); ?>" style="margin:0; border:2px black solid; width:50px; height:50px; display:inline-block;">
      </a>
        <form action="logout.php" method="post" id="logout" style="display:inline-block;">
          <P style="display:inline;">
            <?=h($app->me()->username); ?>:
            (<?=h($app->me()->email); ?>)
            <input class="btnLogOut" type="submit" value="Log Out" style="display:inline">
          </p>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

      </div>
    </div>


  <div class="content">
    <h2>プロフィール</h2>
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

</body>
</html>
