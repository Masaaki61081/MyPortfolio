<?php



require_once(__DIR__ . '/../config/config.php');


$app = new MyApp\Controller\Index();

$app->run();
$thread_Model = new \MyApp\Model\Thread();

$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}

$pre_page = $page - 1;
$next_page = $page + 1;
$last_page = $thread_Model->getThread_page();

$thread_list_page = $thread_Model->getThread_list_page($page);





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
    <h2>スレッド一覧</h2>
    <input type="submit" onclick="location.href='./create_thread.php'" name="" value="新しいスレッドをたてる">
    <br>
    <dl>
    <?php foreach ($thread_list_page as $thread): ?>
            <li>
              <a href ="thread.php?thread_id= <?= h($thread['id']) ?> ">
              <div class="thread">
              <?= h($thread['id'].":")?><?=h($thread['title'])?>
            </div>
            </a>
            </li>
    <?php endforeach; ?>
    </dl>

    <dl>
        <?php
        if ($page == 1) {
          echo "
          <li style=\"display: inline-block;\">
          <p>先頭へ</p>
          </li>
          ";
        }else{
          echo "
          <li style=\"display: inline-block;\">
          <a href =\"index.php?page=1\">
          <p>先頭へ</p>
          </a>
          </li>
          ";
        }
        if ($page == 1) {
          echo "
          <li style=\"display: inline-block;\">
            <p>前へ</p>
          </li>
          ";
        }else{
          echo "
          <li style=\"display: inline-block;\">
            <a href =\"index.php?page=$pre_page\">
              <p>前へ</p>
            </a>
          </li>
          ";
        }
        ?>

      <?php for ($i=1; $i<=$last_page; $i++) : ?>
        <li style="<?php if($i == $page) echo "font-weight:bolder; "; ?>display: inline-block;">
          <?php if($i != $page) echo "<a href =\"index.php?page=$i\">"; ?>
          <?php echo $i ?>
          <?php if($i != $page) echo "</a>" ?>
        </li>
      <?php endfor; ?>

      <?php
      if ($page == $last_page) {
        echo "
        <li style=\"display: inline-block;\">
        <p>次へ</p>
        </li>
        ";
      }else{
        echo "
        <li style=\"display: inline-block;\">
        <a href =\"index.php?page=$next_page\">
        <p>次へ</p>
        </a>
        </li>
        ";
      }
      if ($page == $last_page) {
        echo "
        <li style=\"display: inline-block;\">
          <p>最後へ</p>
        </li>
        ";
      }else{
        echo "
        <li style=\"display: inline-block;\">
          <a href =\"index.php?page=$last_page\">
            <p>最後へ</p>
          </a>
        </li>
        ";
      }
      ?>

    </dl>
  </div>

</body>
</html>
