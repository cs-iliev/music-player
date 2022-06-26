<?php

// Initialize the session 
session_start();

// $_SESSION = array();

// //Destroy the session.
// session_destroy();

// exit;

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../public/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <title>User Login And Registration</title>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="row">
                <div class="col-md-6 login-left">
                    <h2>Login Here</h2>
                    <form action="../src/login/validation.php" method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input id="login-username" type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="login-password" type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </form>
                </div>

                <div class="col-md-6 login-right">
                    <h2>Register Here</h2>
                    <form action="../src/login/registration.php" method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input id="register-username" type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="register-password" type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input id="register-confirm-password" type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>