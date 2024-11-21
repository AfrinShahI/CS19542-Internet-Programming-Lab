<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
$message='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($user['password'] === $password) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php");
                exit();
            } else {
                $message= "<p class='text-danger text-center'>Invalid password.</p>";
            }
        } else {
            $message= "<p class='text-danger text-center'>No user found with that email.</p>";
        }
    } elseif (isset($_POST['register'])) {
        $regEmail = $_POST['regEmail'];
        $regPassword = $_POST['regPassword'];
        $sql = "SELECT * FROM users WHERE email = '$regEmail'";
        $checkResult = mysqli_query($conn, $sql);
        if (mysqli_num_rows($checkResult) == 0) {
            $insert = "INSERT INTO users (email, password) VALUES ('$regEmail', '$regPassword')";
            if (mysqli_query($conn, $insert)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                header("Location: index.php");
                exit();
            } else {
                $message= "<p class='text-danger text-center'>Registration failed.</p>";
            }
        } else {
            $message= "<p class='text-danger text-center'>Email is already registered.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    
    <?php include 'navbar.php'; ?> <!-- Include the navbar here -->
        
    
    <div class="container mt-5">
        <div id="loginContainer" style="display:block;">
            <h2 class="text-center">Login</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary" type="submit" name="login">Login</button>
            </form>
            <p class="mt-3">New user? <button class="btn btn-link" id="toggleRegister">Register Here</button></p>
        </div>

        <div id="registerContainer" style="display:none;">
            <h2 class="text-center">Register</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="regEmail" class="form-label">Email:</label>
                    <input type="email" id="regEmail" name="regEmail" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="regPassword" class="form-label">Password:</label>
                    <input type="password" id="regPassword" name="regPassword" class="form-control" required>
                </div>
                <button class="btn btn-primary" type="submit" name="register">Register</button>
                <p class="mt-3">Already Registered? <button class="btn btn-link" id="toggleLogin">Login Here</button></p>
                
                
            </form>
        </div>
    </div>
    
    <?php
        echo $message;
    ?>

    <script>
        document.getElementById('toggleRegister').addEventListener('click', function() {
            document.getElementById('registerContainer').style.display = 'block';
            document.getElementById('loginContainer').style.display = 'none';
        });

        document.getElementById('toggleLogin').addEventListener('click', function() {
            document.getElementById('registerContainer').style.display = 'none';
            document.getElementById('loginContainer').style.display = 'block';
        });
    </script>

</body>
</html>
