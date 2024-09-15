<?php
include 'conn.php'; // Ensure this file sets up the $conn mysqli connection

// Prepare the query to fetch all users
$sql = 'SELECT * FROM tbl_user ORDER BY id_user';
$result = $conn->query($sql);
$tbl_user = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dash.css">
    <title>User Accounts</title>
</head>
<body>
<div class="container mt-5">
    <h1>Students Information</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="create.php" class="btn btn-primary">Create New Record</a>
    </div>

    <!-- User Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($tbl_user) > 0): ?>
                <?php foreach ($tbl_user as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id_user']) ?></td>
                    <td><?= htmlspecialchars($user['user_name']) ?></td>
                    <td><?= htmlspecialchars($user['birthday']) ?></td>
                    <td><?= htmlspecialchars($user['gender']) ?></td>
                    <td><?= htmlspecialchars($user['user_address']) ?></td>
                    <td class="actions">
                        <a href="update.php?id=<?= htmlspecialchars($user['id_user']) ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?= htmlspecialchars($user['id_user']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
