<?php
session_start();
// Include database connection file
include_once('config.php');
if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title class="text">RC4 Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>

<body style="background-image: url('img/background.svg'); display: flex; flex-direction: column; min-height: 100vh; margin: 0;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed top sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/navbar.png" alt="Brand logo" class="navbar-brand-img mx-auto">
            </a>
            <div class="ml-auto">
                <button class="btn btn-logout" onclick="location.href='logout.php'">
                    <img src="icon/logout.svg" alt="Logout" width="16" height="16">
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid containerTable">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2 class="card-title mb-0">Data User</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($_SESSION['ROLE'] == "admin") {
                                        $query = "SELECT * FROM users";
                                    }
                                    $result = $con->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_array()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['role'] ?></td>
                                                <td><?php echo $row['created_at'] ?></td>
                                            </tr>
                                    <?php    }
                                    } else {
                                        echo "<tr><td colspan='5'><h2 class='text-center'>No record found!</h2></td></tr>";
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mt-4">
                    <div class="card-header">
                        <h2 class="card-title mb-0">Data Enkripsi</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">File Name</th>
                                        <th scope="col">Password Encrypt</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($_SESSION['ROLE'] == "admin") {
                                        $query = "SELECT * FROM files";
                                    }
                                    $result = $con->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_array()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id'] ?></td>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['file_name'] ?></td>
                                                <td><?php echo $row['encryption_key'] ?></td>
                                                <td><?php echo $row['created_at'] ?></td>
                                            </tr>
                                    <?php    }
                                    } else {
                                        echo "<tr><td colspan='4'><h2 class='text-center'>No record found!</h2></td></tr>";
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="css/dashboard.css">
</body>

</html>