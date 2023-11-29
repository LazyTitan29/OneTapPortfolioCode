<?php
include 'db_connect.php';

$user_id = $_POST['user_id'];
$query = "DELETE FROM users WHERE id = '$user_id'";
$conn->query($query);

// Depending on the outcome of the query, you can return a success or failure message to the user

?>
