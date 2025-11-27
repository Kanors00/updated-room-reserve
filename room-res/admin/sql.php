<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'room_reservation';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
  $query = "SELECT * FROM reservations";
} else {
  $query = "SELECT * FROM reservations WHERE user_email = '" . $conn->real_escape_string($_SESSION['user_email']) . "'";
}

$result = $conn->query($query);
if (!$result) {
  die("Query failed: " . $conn->error);
}
