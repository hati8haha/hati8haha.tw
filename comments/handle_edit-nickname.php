<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];

  if (!$_POST['nickname']) {
    header('Location: edit-nickname.php?errCode=1');
    die('需填入新暱稱');
    exit();
  }

  $nickname = $_POST['nickname'];

  $sql = "UPDATE `hati8haha_users` SET `nickname`=? WHERE `username`=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $username);
  $result = $stmt->execute();

  $sql_posts = "UPDATE `hati8haha_posts` SET `nickname`=? WHERE `username`=?";
  $stmt = $conn->prepare($sql_posts);
  $stmt->bind_param('ss', $nickname, $username);
  $result = $stmt->execute();

  $_SESSION['nickname'] = $nickname;

  header("Location: index.php");
?>
