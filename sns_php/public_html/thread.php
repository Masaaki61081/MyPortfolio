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
  <title>Home</title>
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









    <h2>返信一覧</h2>


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

  <div class="content">
    <h2>返信</h2>
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
</body>
</html>
