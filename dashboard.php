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

    <div style="flex: 1; display: flex; flex-direction: column; min-height: calc(100vh - (56px + 200px));">
        <main role="main" class="col-md-9 mx-auto col-lg-10 pt-3 px-4 mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2 text-white">Data User</h1>
            </div>
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
            <hr>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2 text-white">Data Enkripsi</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
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
        </main>
    </div>

    <footer class="bg-light text-center text-lg-start" style="background-image: url('img/background.svg'); flex-shrink: 0;">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-white">Tugas Akhir</h5>
                    <p class="text-white">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
                        molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae
                        aliquam voluptatem veniam, est atque cumque eum delectus sint!
                    </p>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-white">Stay Connected</h5>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-primary btn-floating mx-2" href="https://www.facebook.com/" target="_blank" role="button">
                            <img src="icon/facebook.png" alt="Facebook" width="25px" height="25px">
                        </a>
                        <a class="btn btn-primary btn-floating mx-2" href="https://www.twitter.com/" target="_blank" role="button">
                            <img src="icon/twitter.png" alt="Twitter" width="25px" height="25px">
                        </a>
                        <a class="btn btn-primary btn-floating mx-2" href="https://www.instagram.com/" target="_blank" role="button">
                            <img src="icon/instagram.png" alt="Instagram" width="25px" height="25px">
                        </a>
                        <a class="btn btn-primary btn-floating mx-2" href="https://www.linkedin.com/" target="_blank" role="button">
                            <img src="icon/linkedin.png" alt="LinkedIn" width="25px" height="25px">
                        </a>
                        <a class="btn btn-primary btn-floating mx-2" href="https://www.github.com/" target="_blank" role="button">
                            <img src="icon/github.png" alt="GitHub" width="25px" height="25px">
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class="copyright text-center p-3" style="background-color: #c5c5c5;">
            © 2023 All rights reserved.
        </div>
    </footer>
    <link rel="stylesheet" href="css/dashboard.css">
</body>

</html>