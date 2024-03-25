<?php
// Start the session
session_start();
// Database connection
require "db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the login button is submitted execute this code
if (isset($_POST['submit'])) {
    $form_username = $_POST['username']; // Store username from the form in a variable
    $form_password = $_POST['password']; // Likewise the password

    // Check if username and password are provided
    if (empty($form_username) || empty($form_password)) {
        echo '<div class="alert alert-danger">Please enter both username and password</div>';
    } else {
        // Prepare and execute a query to retrieve user information based on the provided username
        $login = $pdo->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $login->execute([$form_username, $form_password]);
        // Fetch the result as an associative array
        $user = $login->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User found, set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['loggedin'] = true; // Indicate that the user is now logged in

            // Redirect to index.php
            header("Location: index.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Incorrect username or password</div>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the login form */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Login</h2>
                <?php if (!empty($login_error)): ?>
    <div class="alert alert-danger"><?php echo $login_error; ?></div>
<?php endif; ?>

                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                    <a href="create_user.php"><p>Create an account</p></a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
