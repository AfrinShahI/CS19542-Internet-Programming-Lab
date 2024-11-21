<?php
session_start(); // Start the session

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Include the database connection

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT email FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle password update
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        $updateSql = "UPDATE users SET password = '$newPassword' WHERE id = '$user_id'";
        if (mysqli_query($conn, $updateSql)) {
            $message = "<p class='text-success text-center'>Password updated successfully.</p>";
        } else {
            $message = "<p class='text-danger text-center'>Password update failed.</p>";
        }
    } else {
        $message = "<p class='text-danger text-center'>Passwords do not match.</p>";
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    $deleteSql = "DELETE FROM users WHERE id = '$user_id'";
    $deleteSql = "DELETE FROM listings WHERE user_id = '$user_id'";


    if (mysqli_query($conn, $deleteSql)) {
        session_destroy(); // Destroy the session after deletion
        header("Location: login.php");
        exit();
    } else {
        $message = "<p class='text-danger text-center'>Account deletion failed.</p>";
    }
}

// Handle sign out
if (isset($_POST['sign_out'])) {
    session_destroy(); // End session
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <div class="container mt-5">
        <h2 class="text-center">Your Profile</h2>
        <div class="card p-4">
            <!-- Display user email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
            </div>

            <!-- Password update form -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <?php echo $message; ?> <!-- Display success/failure message -->

                
                <button type="submit" class="btn btn-primary" name="update_password">Update Password</button>
            </form>

            
            <!-- Create listing button -->
            <div class="mt-4">
                <a href="create_listing.php" class="btn btn-success">Create a Listing</a> <!-- Link to create listing page -->
            </div>

            <!-- Delete account and sign out buttons -->
            <form action="" method="POST" class="mt-4">
                <button type="submit" class="btn btn-danger" name="delete_account">Delete Account</button>
                <button type="submit" class="btn btn-secondary ms-2" name="sign_out">Sign Out</button>
            </form>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
