<!DOCTYPE html>
<?php
  require_once('conn.php');
  session_start();
  if (empty($_GET['id']) || empty($_SESSION)) {
  	header("Location: index.php");
  	exit();
  }

  $nickname = $_SESSION['nickname'];
  $username = $_SESSION['username'];
  $comment_id = $_GET['id'];

  $sql = "SELECT * FROM hati8haha_posts WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $comment_id);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $content = $row['content'];

  if ($username === $row['username'] || $_SESSION['user_type'] === 0) {
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板-編輯留言</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <header class="warning">
    注意！本站為練習用網站，因教學用途而刻意忽略資安實作，註冊時請勿使用任何真實帳號密碼。
  </header>
  <main class="board">
    <div class="member">
      <a class="sign-up" href="./index.php">回留言板</a> 
      <a class="login" href="./handle_logout.php">登出</a>
    </div>

    <h1 class="board__title">
      編輯留言
    </h1>
    <?php
      if (!empty($_GET['errCode'])) {
        if ($_GET['errCode']==='1') {
    ?>    <div class="empty-alert">資料未填寫完整</div>
    <?php      
        }
      }
    ?>
    <form class="board__new-comment-form" method="POST" action="handle_update_comment.php">
      <div class="board__input">
        <span>留言：</span>
        <textarea name="content" rows="5"><?php echo $content; ?></textarea>
        <input class="hidden" type="text" name="id" value=<?php echo $comment_id; ?> />
      </div>
      <input class="board__submit-btn" type="submit" />
    </form>
    <div class="board__hr"></div>
  </main>
</body>
</html>
<?php
  } else {
  	header("Location: index.php");
  	exit();
  }
?>