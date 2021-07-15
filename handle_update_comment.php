<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];

  if (!$_POST['content']) {
    header('Location: update_comment.php?errCode=1');
    die('QQ');
    exit();
  }

  $new_content = $_POST['content'];
  $comment_id = $_POST['id'];

  $sql = "SELECT * FROM hati8haha_posts WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $comment_id);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();


  if ($username === $row['username'] || $_SESSION['user_type'] === 0) {
    $sql_posts = "UPDATE `hati8haha_posts` SET `content`=? WHERE `id`=?";
    $stmt = $conn->prepare($sql_posts);
    $stmt->bind_param('si', $new_content, $comment_id);
    $result = $stmt->execute();
  } else {
    echo "<script type='text/javascript'>alert('新增失敗')</script>";
    header("Location: index.php");
    exit();
  }
  header("Location: index.php");
?>
