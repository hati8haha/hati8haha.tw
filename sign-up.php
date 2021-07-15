<!DOCTYPE html>
<?php
  require_once('conn.php');

?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板-註冊</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <header class="warning">
    注意！本站為練習用網站，因教學用途而刻意忽略資安實作，註冊時請勿使用任何真實帳號密碼。
  </header>
  <main class="board">
    <div class="member">
      <a class="sign-up" href="./index.php">回留言板</a> 
      <a class="login" href="./login.php">登入</a>
    </div>

    <h1 class="board__title">
      註冊會員
    </h1>
    <?php
      if (!empty($_GET['errCode'])) {
        if ($_GET['errCode']==='1') {
    ?>    <div class="empty-alert">資料未填寫完整</div>
    <?php      
        } elseif ($_GET['errCode']==='2') {
    ?>    <div class="empty-alert">此帳號已有人註冊</div>
    <?php 
        }
      }
    ?>
    <form class="board__new-comment-form" method="POST" action="handle_sign-up.php">
      <div class="board__input">
        <span>暱稱：</span>
        <input type="text" name="nickname"/>
      </div>
      <div class="board__input">
        <span>帳號：</span>
        <input type="text" name="username"/>
      </div>
      <div class="board__input">
        <span>密碼：</span>
        <input type="password" name="password"/>
      </div>
      <input class="board__submit-btn" type="submit" />
    </form>
    <div class="board__hr"></div>
  </main>
</body>
</html>