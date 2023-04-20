<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['ID'])) {
    // Redirect to appropriate page based on user role
    if ($_SESSION['ROLE'] == 'admin') {
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
// Include database connectivity

include_once('config.php');

if (isset($_POST['submit'])) {
    $errorMsg = "";
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string(md5($_POST['password']));

    if (!empty($username) || !empty($password)) {
        $query  = "SELECT * FROM users WHERE username = '$username'";
        $result = $con->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['ID'] = $row['id'];
            $_SESSION['ROLE'] = $row['role'];
            $_SESSION['NAME'] = $row['name'];
            if ($row['role'] == 'admin') {
                header("Location: dashboard.php");
                die();
            } else {
                header("Location: index.php");
                die();
            }
        } else {
            $errorMsg = "No user found on this username";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            background-color: #222831;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            margin: auto;
            background-color: #393E46;
            border: 1px solid #393E46;
            border-radius: 5px;
            box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.25);
        }

        .btn-primary {
            background-color: #6B728E;
            border-color: #6B728E;
        }

        .btn-primary:hover {
            background-color: #7286D3;
            border-color: #7286D3;
        }

        .text {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h3 class="text">Login</h3>
        <br>

        <?php if (isset($errorMsg)) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <p class="text">Don't have an account?<a href="register.php"> Register here!</a></p>
                <input type="submit" name="submit" class="btn btn-primary btn-success" value="Login">
            </div>
        </form>

    </div>
</body>

</html>