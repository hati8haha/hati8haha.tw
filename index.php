<!DOCTYPE html>
<?php
  require_once('conn.php');
  require_once("utils.php");
  session_start();
  if (!empty($_SESSION)) {
    $username = $_SESSION['username'];
    $nickname = $_SESSION['nickname'];
  }

  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 10;
  $offset = ($page - 1) * $items_per_page;
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <header class="warning">
    注意！本站為練習用網站，因教學用途而刻意忽略資安實作，註冊時請勿使用任何真實帳號密碼。
  </header>
  <main class="board">
    <div class="member">
      <?php 
        if (!empty($_SESSION)) {
      ?>
          <div class="member__info">您好，<?php echo escape($nickname) ?></div>
        <?php
          if ($_SESSION['user_type'] === 0) {
            echo "<a class='manage_users-btn' href='./manage_users.php'>管理權限</a>";
          }
        ?>
          <a class="edit-nickname" href="./edit-nickname.php">編輯暱稱</a>
          <a class="logout" href="./handle_logout.php">登出</a>
      <?php
        } else {
      ?>
          <a class="sign-up" href="./sign-up.php">註冊</a> 
          <a class="login" href="./login.php">登入</a>
      <?php
        }
      ?>
    </div>
    <h1 class="board__title">
      留言板
    </h1>
    <?php
      if (!empty($_GET['errCode'])) {
    ?>
    <div class="empty-alert">資料未填寫完整</div>
    <?php
      }
    ?>
    <form class="board__new-comment-form" method="POST" action="handle_add_comment.php">
      <?php 
        if (empty($_SESSION)) {
      ?>
          <div class="board__nickname">
            <span>暱稱：</span>
            <input type="text" name="nickname"/>
          </div>
          <textarea name="content" rows="5"></textarea>
          <input class="board__submit-btn" type="submit" /> 
      <?php 
        } elseif ($_SESSION['user_type'] === 2){
          echo "您已被停權，無法新增留言。";
        } else {
      ?>
          <textarea name="content" rows="5"></textarea>
          <input class="board__submit-btn" type="submit" />      
      <?php
        }
      ?>
    </form>
    <div class="board__hr"></div>
    <section>
      <?php
        $stmt = $conn->prepare("SELECT * FROM `hati8haha_posts` WHERE is_deleted = 0 LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $items_per_page, $offset);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) { 
      ?>
          <div class="card">
            <div class="card__avatar">
            </div>
            <div class="card__body">
              <div class="card__upper">
                <div class="card__info">
                  <span class="card__author">
                    <?php echo escape($row['nickname']); ?>
                  </span>
                  <span class="card__username">(@</span>
                  <span class="card__username ellipsis">
                    <?php echo escape($row['username']); ?>
                  </span>
                  <span class="card__username">)</span>
                  <span class="card__time"><?php echo escape($row['created_at']); ?></span>
                </div>
                <?php
                  if (!empty($_SESSION) && $username === $row['username'] || !empty($_SESSION) && $_SESSION['user_type'] === 0) {
                ?>
                <div class="card__edit">
                  <a class="card__edit-btn" href=<?php echo "./update_comment.php?id=" . $row['id']?>>✏️</a>
                  <a class="card__delete-btn" href=<?php echo "./handle_delete_comment.php?id=" . $row['id']?>>🗑️</a>
                </div>
                <?php
                  }
                ?>
              </div>
              <p class="card__content"><?php echo escape($row['content']); ?></p>
            </div>
          </div>
        <?php } ?>
    </section>
    <div class="board__hr"></div>
    <?php
      $stmt = $conn->prepare(
        'select count(id) as count from hati8haha_posts where is_deleted = 0'
      );
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>
    <div class="paginator">
      <?php if ($page != 1) { ?> 
        <a href="index.php?page=1">首頁</a>
        <a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a>
      <?php } ?>
      <?php if ($page != $total_page) { ?>
        <a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a>
        <a href="index.php?page=<?php echo $total_page ?>">最後一頁</a> 
      <?php } ?>
    </div>
    <div class="page-info">
      <span>總共有 <?php echo $count ?> 筆留言，頁數：</span>
      <span><?php echo $page ?> / <?php echo $total_page ?></span>
    </div>
  </main>
</body>
</html>