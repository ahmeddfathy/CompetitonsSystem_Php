<?php
session_start();
include("config.php");

if(isset($_POST['signup'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type']; // New line to retrieve type from form
    
    // Validation
    if(empty($email) || empty($username) || empty($password) || empty($type)) { // Modified line to include type
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if(mysqli_num_rows($check_email) > 0) {
            $error = "Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, username, password, type) VALUES ('$email', '$username', '$hashed_password', '$type')";
            if(mysqli_query($conn, $sql)) {
                $success = "Account created successfully!";
                // Redirect to login page after successful signup
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Add User</h2>
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } elseif(isset($success)) { ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php } ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="type" placeholder="Type" required>
                                 <!-- New input field for type -->
                            </div>
                            <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
                        </form>
                    </div>
                    <div class="card-footer text-center mt-3">
                        <p class="mb-0 text-muted">Already have an account? <a href="login.php">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
