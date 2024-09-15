<?php
include 'conn.php'; // Make sure the $conn connection is set
session_start();

// Get the user ID from the URL query string
$id_user = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_user > 0) {
    // Fetch user details for the provided ID
    $stmt = $conn->prepare('SELECT * FROM tbl_user WHERE id_user = ?');
    $stmt->bind_param('i', $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo 'User not found';
        exit;
    }

    // Update user details if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
        $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
        $user_address = isset($_POST['user_address']) ? trim($_POST['user_address']) : '';

        if ($user_name && $birthday && $gender && $user_address) {
            // Update user information in the database
            $stmt = $conn->prepare('UPDATE tbl_user SET user_name = ?, birthday = ?, gender = ?, user_address = ? WHERE id_user = ?');
            $stmt->bind_param('ssssi', $user_name, $birthday, $gender, $user_address, $id_user);
            $stmt->execute();

            // Redirect to the dashboard after successful update
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Please fill in all required fields!';
        }
    }
} else {
    echo 'Invalid user ID';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/all.css">
</head>
<body>
<div class="container mt-5">
    <h2>Update User</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Pre-fill form with existing user data -->
    <form action="update.php?id=<?= htmlspecialchars($id_user) ?>" method="POST">
        <div class="form-group">
            <label for="user_name">Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" value="<?= htmlspecialchars($user['user_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="<?= htmlspecialchars($user['birthday']) ?>" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_address">Address</label>
            <input type="text" name="user_address" id="user_address" class="form-control" value="<?= htmlspecialchars($user['user_address']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
</body>
</html>
