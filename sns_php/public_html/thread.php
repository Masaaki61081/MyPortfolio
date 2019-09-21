<?php



require_once(__DIR__ . '/../config/config.php');


$thread_id = $_GET['thread_id'];
$app = new MyApp\Controller\Thread();

$app->run($thread_id);
$thread_Model = new \MyApp\Model\Thread();
$threads = $thread_Model->getTHREAD_list();
$threadTitle = $thread_Model->getTHREAD_title($thread_id);
$responses1 = $thread_Model->getRes($thread_id);
$maxres= $thread_Model->getResnum($thread_id);
$newResNum = $maxres + 1;
$responses = $app->getValues()->responses;




?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Thread</title>
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
          <h2>返信一覧</h2>
        </div>
        <div class="window_content">
          <input type="submit" onclick="location.href='./index.php'" name="" value="スレッド一覧へ">
          <br>
          <?= "<h4>", h($threadTitle), "</h4>" ?>
          <br>
          <dl>

            <li>
              <?php foreach ($responses as $res): ?>
                <div class="res">
                  <a href="profile.php?user_id=<?= $res['writer'] ?>">
                    <?= $res['comment_id'] , ":<img src=\"../picture/icon/" , $res['icon'] , "\" style=\"margin:0; border:2px black solid; width:50px; height:50px; display:inline-block;\"><p style=\"display:inline-block;\">" , $res['username'] , "</p>:" ?>
                  </a>
                  <?= "<p style=\"display:inline-block;\">" , $res['content'] , "</p>" ; ?>
                </div>
              <?php endforeach; ?>
            </li>
          </dl>

        </div>
      </div>
      <div class="window">
        <div class="window_title">
          <h2>返信</h2>
        </div>
        <div class="window_content">
          <form class="postform" action=""   method="post" id="postform">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            <input type="hidden" name="writer" value="<?= h($app->me()->id); ?>">
            <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
            <input type="hidden" name="newResNum" value="<?= h($newResNum); ?>">

            <textarea class="content" name="content" id="content" rows="8" cols="80"></textarea>
            <br>
            <p class="err"><?= h($app->getErrors('write')); ?></p>
            <div class="btn" onclick="document.getElementById('postform').submit();">返信する</div>
            <input class="input" type="reset" value="リセット">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
