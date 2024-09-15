<?php
include 'conn.php'; // Ensure this file sets up the $conn MySQLi connection
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure form values are properly received and sanitized
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $birthday = isset($_POST['date']) ? trim($_POST['date']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $user_address = isset($_POST['user_address']) ? trim($_POST['user_address']) : '';       

    // Check that all fields are filled in
    if ($user_name && $birthday && $gender && $user_address) {
        try {
            // Use MySQLi prepared statements for the query
            $stmt = $conn->prepare('INSERT INTO tbl_user (user_name, birthday, gender, user_address) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $user_name, $birthday, $gender, $user_address); // Bind the parameters
            $stmt->execute(); // Execute the query
            
            // Redirect to dashboard after successful insertion
            header('Location: dashboard.php');
            exit();
        } catch (mysqli_sql_exception $e) {
            $error = 'Database error: ' . $e->getMessage(); // Catch any MySQLi errors
        }
    } else {
        $error = 'Please fill in all required fields!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/all.css">
</head>
<body>
<div class="container mt-5">
    <h2>Create Record</h2>
    <!-- Display error message if there is any -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Form to create a new user -->
    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="user_name">Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date">Birthday</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_address">Address</label>
            <input type="text" name="user_address" id="user_address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>