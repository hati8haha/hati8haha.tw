<!DOCTYPE html>
<?php
  require_once('conn.php');
  require_once("utils.php");
  session_start();
  if (!empty($_SESSION)) {
    $username = $_SESSION['username'];
    $nickname = $_SESSION['nickname'];
    $user_type = $_SESSION['user_type'];
  }

  if ($user_type !== 0) {
    header("Location: index.php");
    exit();
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
  <title>留言板後台</title>
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
          <a class="edit-nickname" href="./index.php">回留言板</a>
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
      管理權限
    </h1>
    <?php
      if (!empty($_GET)) {
        if ($_GET['success']==='1') {
    ?>    <div class="empty-alert">修改成功！</div>
    <?php      
        }
      }
    ?>
    <div class="board__hr"></div>
    <section>
      <form  class="manage__users" method="POST" action="handle_manage_users.php">
      <table class="users__table">
        <thead>
          <tr>
            <th class="table__id">user id</th>
            <th class="table__nickname">nickname</th>
            <th class="table__username">username</th>
            <th class="table__usertype">user type</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $stmt = $conn->prepare("SELECT * FROM `hati8haha_users`");
          $result = $stmt->execute();
          $result = $stmt->get_result();
          while ($row = $result->fetch_assoc()) { 
        ?>
          <tr>
              <td class="table__id"><?php echo escape($row['id']); ?></td>
              <td class="table__nickname"><?php echo escape($row['nickname']); ?></td>
              <td class="table__username"><?php echo escape($row['username']); ?></td>
              <td class="table__usertype">
                <select name=<?php echo 'user__type' . escape($row['id']); ?>>
                  <option value="0" <?php if ($row['user_type'] === 0) {
                    echo "selected='selected'";
                  } ?>>
                    管理員
                  </option>
                  <option value="1" <?php if ($row['user_type'] === 1) {
                    echo "selected='selected'";
                  } ?>>
                    一般使用者
                  </option>
                  <option value="2" <?php if ($row['user_type'] === 2) {
                    echo "selected='selected'";
                  } ?>>
                    遭停權使用者
                  </option>
                </select>
              </td>
          </tr>
        <?php
          }
        ?>
        </tbody>
      </table>
        <input class="board__submit-btn manage__users" type="submit" />
      </form>
    </section>

    <div class="board__hr"></div>

    <?php
      $stmt = $conn->prepare(
        'select count(id) as count from hati8haha_users'
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
      <span>總共有 <?php echo $count ?> 筆使用者資料，頁數：</span>
      <span><?php echo $page ?> / <?php echo $total_page ?></span>
    </div>
  </main>
</body>
</html>