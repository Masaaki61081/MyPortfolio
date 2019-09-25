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
                  <?= h($app->me()->username) ?><br>
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
      <script type="text/javascript" src="menu.js"></script>
