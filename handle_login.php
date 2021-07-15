<?php
  require_once('conn.php');
  session_start();
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (empty($username) || empty($password)) {
    header('Location: login.php?errCode=1');
    die('資料不齊全');
    exit();
  }

  $sql = "SELECT * FROM hati8haha_users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    header('Location: login.php?errCode=2');
    die('此帳號不存在');
    exit();
  }

  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    $_SESSION['username'] = $username;
    $_SESSION['nickname'] = $row['nickname'];
    $_SESSION['user_type'] = $row['user_type'];
  } else {
    header('Location: login.php?errCode=3');
    die('密碼輸入錯誤');
    exit();
  }

  header("Location: index.php");
?>