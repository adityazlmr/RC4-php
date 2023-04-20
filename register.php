<?php
// Include database connection file
include_once('config.php');
if (isset($_POST['submit'])) {

    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string(md5($_POST['password']));
    $name     = $con->real_escape_string($_POST['name']);
    $role     = $con->real_escape_string($_POST['role']);
    $query  = "INSERT INTO users (name,username,password,role) VALUES ('$name','$username','$password','$role')";
    $result = $con->query($query);
    if ($result == true) {
        header("Location:login.php");
        die();
    } else {
        $errorMsg  = "You are not Registred..Please Try again";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h3 class="text">Register</h3>
        <?php if (isset($errorMsg)) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Enter Name" required="">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter Username" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" required="">
            </div>
            <div class="form-group">
                <label class="text" for="role">Role:</label>
                <select class="form-control" name="role" required="">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="form-group">
                <p class="text">Already have account ?<a href="login.php"> Login</a></p>
                <input type="submit" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>