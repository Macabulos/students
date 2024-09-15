<?php
include 'conn.php'; // Ensure the $conn mysqli connection is set
session_start();

// Get the user ID from the URL query string
$id_user = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_user > 0) {
    // Prepare the SQL delete query
    $stmt = $conn->prepare('DELETE FROM tbl_user WHERE id_user = ?');
    $stmt->bind_param('i', $id_user);
    $stmt->execute();

    // Redirect to dashboard after deletion
    header('Location: dashboard.php');
    exit();
} else {
    echo 'Invalid user ID';
}
?>
