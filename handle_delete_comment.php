<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];

  $comment_id = $_GET['id'];

  $sql = "SELECT * FROM hati8haha_posts WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $comment_id);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();


  if ($username === $row['username'] || $_SESSION['user_type'] === 0) {
    $sql_delete = "UPDATE `hati8haha_posts` SET `is_deleted`=1 WHERE `id`=?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param('i', $comment_id);
    $result = $stmt->execute();
  } else {
    echo "<script type='text/javascript'>alert('刪除失敗')</script>";
    header("Location: index.php");
    exit();
  }

  header("Location: index.php");
?>
