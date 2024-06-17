<?php
session_start();
include("config.php");

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            if(password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email; // Save user email in session
                $_SESSION['username'] = $row['username']; // Save username in session
                $_SESSION['type'] = $row['type']; // Save user type in session
                header("Location: Competitions.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }

    if($email === 'admin@admin' && $password === 'admin') {
        // Redirect admin user to admin.php
        header("Location: admin.php");
        exit();
    } 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
    <script>
        setTimeout(function() {
            document.getElementById('alert').style.display = 'none';
        }, 5000);
    </script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Login</h2>
                        <?php if(isset($error)) { ?>
                            <div id="alert" class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Don't have an account yet? <a href="index.php">Sign up here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
