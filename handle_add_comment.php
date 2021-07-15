<?php
  require_once('conn.php');
  session_start();

  if (empty($_SESSION)) {
    $nickname = $_POST['nickname'];
    $username = '匿名使用者';
  } else {
    $nickname = $_SESSION['nickname'];
    $username = $_SESSION['username'];
  }

  $content = $_POST['content'];
  if (empty($nickname) || empty($content)) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
    exit();
      }
  $sql = "INSERT INTO hati8haha_posts(nickname, username, content) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $nickname, $username, $content);
  $stmt->execute();
  header("Location: index.php");
?>
