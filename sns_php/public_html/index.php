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
  <link rel="stylesheet" href="css/style_pc.css" media="screen and (min-width: 960px)">
  <link rel="stylesheet" href="css/style_tab.css" media="screen and (max-width: 960px)">
  <link rel="stylesheet" href="css/style_sp.css" media="screen and (max-width: 600px)">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
  $(function() {
    $("#header").load("header.php");
  });
  </script>
</head>
<body>
  <div class="wrapper">
    <div class="header" id="header">
    </div>

    <div class="container">
      <div class="window">
        <div class="window_title">
          <h2>スレッド一覧</h2>
        </div>
        <div class="window_content">
          <br>
          <div class="thread_list">
            <ul>
              <?php foreach ($thread_list_page as $thread): ?>
                <li>
                  <a href ="thread.php?thread_id= <?= h($thread['id']) ?> ">
                    <div class="thread_list_item">
                      <div class="thread_list_item_title">
                        <?= h($thread['id'].":")?><?=h($thread['title'])?>
                        <!-- <span class="thread_list_item_info">
                        最終更新日:
                        </span> -->
                      </div>
                      <div class="thread_list_item_content">
                        <div class="thread_list_item_content_user">
                          <?= "<img src=\"../picture/icon_thumbnail/" , $thread['icon'] , "\" style=\"margin:0; width:50px; height:50px; display:inline-block;\"><p style=\"display:inline-block;\">" , $thread['username'] , "</p>" ?>
                        </div>
                        <div class="thread_list_item_content_text">
                          本文
                        </div>

                      </div>
                    </div>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <input class="button" type="submit" onclick="location.href='./create_thread.php'" name="" value="新しいスレッドをたてる">
          <div class="pagination">
            <ul>
              <?php
              if ($page == 1) {
                echo "
                <li style=\"display: inline-block;\">
                先頭へ
                </li>
                ";
              }else{
                echo "
                <li style=\"display: inline-block;\">
                <a href =\"index.php?page=1\">
                先頭へ
                </a>
                </li>
                ";
              }
              if ($page == 1) {
                echo "
                <li style=\"display: inline-block;\">
                前へ
                </li>
                ";
              }else{
                echo "
                <li style=\"display: inline-block;\">
                <a href =\"index.php?page=$pre_page\">
                前へ
                </a>
                </li>
                ";
              }
              ?>
              </li>

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
              </ul>
          </div>
        </div>
        </div>
      </div>
  </div>
</body>
</html>
