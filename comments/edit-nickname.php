<!DOCTYPE html>
<?php
  require_once('conn.php');
  session_start();
  $nickname = $_SESSION['nickname'];
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板-編輯暱稱</title>
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
      編輯暱稱
    </h1>
    <?php
      if (!empty($_GET['errCode'])) {
        if ($_GET['errCode']==='1') {
    ?>    <div class="empty-alert">資料未填寫完整</div>
    <?php      
        }
      }
    ?>
    <form class="board__new-comment-form" method="POST" action="handle_edit-nickname.php">
      <div class="board__input">
        <span>暱稱：</span>
        <input type="text" name="nickname" value= <?php echo $nickname; ?> />
      </div>
      <input class="board__submit-btn" type="submit" />
    </form>
    <div class="board__hr"></div>
  </main>
</body>
</html>