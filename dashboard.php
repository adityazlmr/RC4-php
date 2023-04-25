<?php
session_start();

// Include database connection file
include_once('config.php');

if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
} else {
    $user_role = $_SESSION['ROLE'];
    if ($user_role != 'admin') {
        header("Location:unauthorized.php");
        exit();
    }
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
    <nav class="mainnavbar navbar navbar-expand-lg fixed top sticky-top">
        <div class="container-fluid">
            <a class="mainnavbar-brand navbar-brand" href="#">
                <img src="img/navbar.png" alt="Brand logo" class="mainnavbar-brand-img navbar-brand-img mx-auto">
            </a>
            <div class="ml-auto">
                <button class="btn btn-logout" onclick="location.href='logout.php'" title="Logout">
                    <img src="icon/logout.svg" alt="Logout" width="16" height="16">
                </button>
            </div>
        </div>
    </nav>

    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
        <div class="position-sticky">
            <div class="sidebar-brand">
                <a>DASHBOARD</a>
            </div>
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true" id="userMenu">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Data User</span>
                </a>
                <hr>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="encryptMenu">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Data Enkripsi</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid containerTable">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm table-card" id="table-user">
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
                <div class="card shadow-sm table-card" id="table-enkripsi">
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
        <script>
            var encryptMenu = document.getElementById("encryptMenu");
            var userMenu = document.getElementById("userMenu");
            var userTable = document.getElementById("table-user");
            var encryptTable = document.getElementById("table-enkripsi");

            encryptTable.classList.add("hide-table");

            encryptMenu.addEventListener("click", function() {
                userTable.classList.add("hide-table");
                encryptTable.classList.remove("hide-table");
                encryptMenu.classList.add("active");
                userMenu.classList.remove("active");
            });

            userMenu.addEventListener("click", function() {
                encryptTable.classList.add("hide-table");
                userTable.classList.remove("hide-table");
                userMenu.classList.add("active");
                encryptMenu.classList.remove("active");
            });
        </script>
    </div>
    <link rel="stylesheet" href="css/dashboard.css">
</body>

</html>