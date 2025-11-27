<?php
include 'db_conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, full_name, email, password_hash, role, username FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $fullName, $email, $hashedPassword, $role, $username);
    $stmt->fetch();


    if (is_string($hashedPassword) && password_verify($password, $hashedPassword)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $username;
      $_SESSION['role'] = $role;
      $_SESSION['user_email'] = $email;

      $stmt->close();
      $conn->close();
      if ($role === 'admin') {
        header("Location: /room-res/admin/admin-dashboard.php");
      } else {
        header("Location: home.php");
      }
      exit();
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "User not found.";
  }

  if ($stmt) $stmt->close();
  if ($conn) $conn->close();
}
