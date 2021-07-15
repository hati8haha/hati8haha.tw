<?php
  require_once('conn.php');
  require_once("utils.php");
  session_start();
  $username = $_SESSION['username'];

  $stmt = $conn->prepare("SELECT * FROM `hati8haha_users`");
  $result = $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $post_name = 'user__type' . escape($row['id']);
    $sql = "UPDATE `hati8haha_users` SET `user_type`=? WHERE `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $_POST[$post_name], $row['id']);
    $stmt->execute();
  }

  header("Location: manage_users.php?success=1");
?>
