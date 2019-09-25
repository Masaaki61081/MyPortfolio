<?php



require_once(__DIR__ . '/../config/config.php');


$thread_id = $_GET['thread_id'];
$app = new MyApp\Controller\Thread();

$app->run($thread_id);
$thread_Model = new \MyApp\Model\Thread();
$threads = $thread_Model->getTHREAD_list();
$threadTitle = $thread_Model->getTHREAD_title($thread_id);
$maxres= $thread_Model->getResnum($thread_id);
$newResNum = $maxres + 1;
$responses = $app->getValues()->responses;




?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Thread</title>
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
          <h2>返信一覧</h2>
        </div>
        <div class="window_content">
          <input class="button" type="button" onclick="location.href='./index.php'" name="" value="スレッド一覧へ">
          <br>
          <div class="window_content_title">
            <?= "<h4>", h($threadTitle), "</h4>" ?>
          </div>
          <ul class="response">

              <?php foreach ($responses as $res): ?>
                <li class="res">
                <div class="res_block">
                  <?= $res['comment_id'] ;?>
                  <div class="res_block_userinfo">
                    <a href="profile.php?user_id=<?= $res['writer'] ?>">
                      <?= "<img src=\"../picture/icon/" , $res['icon'] , "\" style=\"margin:0; width:50px; height:50px; display:inline-block;\"><p style=\"display:inline-block;\">" , $res['username'] , "</p>" ?>
                    </a>
                  </div>
                  <div class="res_block_content">
                    <?= "<p style=\"display:inline-block;\">" , $res['content'] , "</p>" ; ?>
                  </div>
                </div>
              </li>
              <?php endforeach; ?>
          </ul>

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

            <textarea class="" name="content" id="content" rows="8" cols="80"></textarea>
            <br>
            <p class="err"><?= h($app->getErrors('write')); ?></p>
            <div class="button_submit" onclick="document.getElementById('postform').submit();">返信する</div>
            <div class="button_submit" onclick="document.getElementById('postform').reset();">リセット</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
