<?php
session_start();

// Include database connection file
include_once('config.php');

if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
} else {
    $user_role = $_SESSION['ROLE'];
    if ($user_role != 'superadmin') {
        header("Location:unauthorized.php");
        exit();
    }
}

include_once("config.php");
// Cek apakah form telah di-submit
if (isset($_POST['submit'])) {
    // Ambil nilai dari form
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string(md5($_POST['password']));
    $name     = $con->real_escape_string($_POST['name']);
    $role     = $con->real_escape_string($_POST['role']);

    // Cek apakah username sudah ada di database
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $con->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $errorMsg = "Username already exists. Please choose a different username.";
    } else {
        // Username belum ada di database, lakukan operasi INSERT
        $query  = "INSERT INTO users (name, username, password, role) VALUES ('$name','$username','$password','$role')";
        $result = $con->query($query);

        if ($result) {
            echo '<script>alert("User added successfully.");</script>';
            header("Location: superadminpage.php");
            die();
        } else {
            $errorMsg = "Failed to add user. Please try again.";
        }
    }
}

include_once("config.php");
if (isset($_POST['delete'])) {
    $deleteId = $con->real_escape_string($_POST['delete_id']);
    $deleteQuery = "DELETE FROM users WHERE id_user = '$deleteId'";
    $deleteResult = $con->query($deleteQuery);

    if ($deleteResult) {
        echo '<script>alert("User deleted successfully."); window.location.href = window.location.href;</script>';
        // Ganti 'User deleted successfully.' dengan pesan atau tindakan yang diinginkan setelah berhasil menghapus pengguna.
    } else {
        echo '<script>alert("Failed to delete user. Please try again.");</script>';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title class="text">Super Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/superadminpage.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
</head>

<body style="background-image: url('img/jkl.jpeg');">

    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
        <div class="position-sticky">
            <div class="sidebar-brand">
                <a>DASHBOARD</a>
            </div>
            <div class="list-group list-group-flush mx-3 mt-4">
                <hr>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true" id="userMenu">
                    <i class="fas fa-user me-3"></i><span> Data User</span>
                </a>
                <hr>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="dataencryptMenu">
                    <i class="fas fa-file-alt me-3"></i><span> Data Enkripsi</span>
                </a>
                <hr>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="encryptMenu">
                    <i class="fas fa-lock me-3"></i><span> Encrypt</span>
                </a>
                <hr>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="decryptMenu">
                    <i class="fas fa-lock-open me-3"></i><span> Decrypt</span>
                </a>
                <hr>
                <button class="btn btn-logout fas fa-sign-out-alt" onclick="location.href='logout.php'" title="Logout"> Logout</button>
                <hr>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm table-card" id="table-user">
                    <div class="card-header">
                        <h2 class="card-title mb-0">Data User</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-inline mb-3">
                            <button class="btn btn-add" id="add-user-btn">Add User</button>
                            <div id="add-user-form" style="display: none;">
                                <form action="" method="POST" autocomplete="off">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role:</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="user">User</option>
                                            <option value="superadmin">Super Admin</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-add">Add</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="search-user" placeholder="Search...">
                            </div>
                        </div>

                        <script>
                            var addUserBtn = document.getElementById("add-user-btn");
                            var addUserForm = document.getElementById("add-user-form");

                            addUserBtn.addEventListener("click", function() {
                                if (addUserForm.style.display === "none") {
                                    addUserForm.style.display = "block";
                                } else {
                                    addUserForm.style.display = "none";
                                }
                            });
                        </script>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="sticky-top">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body-user">
                                    <?php
                                    if ($_SESSION['ROLE'] == "superadmin") {
                                        $query = "SELECT * FROM users";
                                    }
                                    $result = $con->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_array()) {
                                            $userId = $row['id_user'];
                                            $deleteButton = '<button type="submit" name="delete" class="btn btn-delete fas fa-trash-alt" onclick="return confirmDelete()"></button>';

                                            // Memeriksa apakah ID dalam array yang ingin disembunyikan
                                            if (in_array($userId, [1, 2, 3])) {
                                                $deleteButton = ''; // Menyembunyikan tombol delete
                                            }
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id_user'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['role'] ?></td>
                                                <td><?php echo $row['created_at'] ?></td>
                                                <td>
                                                    <form method="POST">
                                                        <input type="hidden" name="delete_id" value="<?php echo $row['id_user'] ?>">
                                                        <?php echo $deleteButton; ?>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'><h2 class='text-center'>No record found!</h2></td></tr>";
                                    }
                                    ?>
                                </tbody>
                                <script>
                                    function confirmDelete() {
                                        return confirm("Are you sure you want to delete this data?");
                                    }
                                </script>
                            </table>
                        </div>
                    </div>

                    <script>
                        // function to filter table rows based on user input
                        function filterTable() {
                            var input = document.getElementById("search-user");
                            var filter = input.value.toUpperCase();
                            var table = document.getElementById("table-body-user");
                            var rows = table.getElementsByTagName("tr");
                            for (var i = 0; i < rows.length; i++) {
                                var cells = rows[i].getElementsByTagName("td");
                                var found = false;
                                for (var j = 0; j < cells.length - 1; j++) {
                                    var cell = cells[j];
                                    if (cell) {
                                        var text = cell.textContent || cell.innerText;
                                        if (text.toUpperCase().indexOf(filter) > -1) {
                                            found = true;
                                            break;
                                        }
                                    }
                                }
                                if (found) {
                                    rows[i].style.display = "";
                                } else {
                                    rows[i].style.display = "none";
                                }
                            }
                        }

                        // add event listener to input field
                        var input = document.getElementById("search-user");
                        input.addEventListener("keyup", filterTable);
                    </script>
                </div>


                <div class="card shadow-sm table-card" id="table-enkripsi">
                    <div class="card-header">
                        <h2 class="card-title mb-0">Data Enkripsi</h2>
                    </div>
                    <div class="card-body">
                        <form class="form-inline mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="search-files" placeholder="Search...">
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="sticky-top">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">File Name</th>
                                        <th scope="col">Password Encrypt</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body-files">
                                    <?php
                                    if ($_SESSION['ROLE'] == "superadmin") {
                                        $query = "SELECT * FROM files";
                                    }
                                    $result = $con->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_array()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id_files'] ?></td>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['file_name'] ?></td>
                                                <td><?php echo $row['encryption_key'] ?></td>
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
                    <script>
                        // function to filter table rows based on user input
                        function filterTable() {
                            var input = document.getElementById("search-files");
                            var filter = input.value.toUpperCase();
                            var table = document.getElementById("table-body-files");
                            var rows = table.getElementsByTagName("tr");
                            for (var i = 0; i < rows.length; i++) {
                                var cells = rows[i].getElementsByTagName("td");
                                var found = false;
                                for (var j = 0; j < cells.length - 2; j++) {
                                    var cell = cells[j];
                                    if (cell) {
                                        var text = cell.textContent || cell.innerText;
                                        if (text.toUpperCase().indexOf(filter) > -1) {
                                            found = true;
                                            break;
                                        }
                                    }
                                }
                                if (found) {
                                    rows[i].style.display = "";
                                } else {
                                    rows[i].style.display = "none";
                                }
                            }
                        }

                        // add event listener to input field
                        var input = document.getElementById("search-files");
                        input.addEventListener("keyup", filterTable);
                    </script>

                </div>

                <section id="formCont">
                    <div class="container" id="encryptForm" style="display: none;">
                        <h2 class="text-center mb-4">Encryption</h2>
                        <form action="rc4.php" method="post" enctype="multipart/form-data" id="rc4-form" autocomplete="off">
                            <div class="mb-4">
                                <label for="encryptionKey" class="form-label">Encryption Key</label>
                                <input type="password" class="form-control" id="encryptionKey" placeholder="minimal 8 karakter" name="encryptionKey" required>
                            </div>
                            <div class="mb-4">
                                <label for="fileToEncrypt" class="form-label">File to Encrypt</label>
                                <input type="file" class="form-control" id="fileToEncrypt" name="fileToEncrypt" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="encrypt" id="encryptBtn" disabled>Encrypt</button>
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#infoModal" style="float: right">
                                <i class="fas fa-question-circle"></i> Help
                            </a>
                        </form>
                    </div>

                    <script>
                        //disable button
                        const encryptionKeyInput = document.getElementById('encryptionKey');
                        const fileToEncryptInput = document.getElementById('fileToEncrypt');
                        const encryptBtn = document.getElementById('encryptBtn');

                        encryptionKeyInput.addEventListener('input', () => {
                            if (encryptionKeyInput.value.length >= 8 && fileToEncryptInput.files.length > 0) {
                                encryptBtn.disabled = false;
                            } else {
                                encryptBtn.disabled = true;
                            }
                        });

                        fileToEncryptInput.addEventListener('input', () => {
                            if (encryptionKeyInput.value.length >= 8 && fileToEncryptInput.files.length > 0) {
                                encryptBtn.disabled = false;
                            } else {
                                encryptBtn.disabled = true;
                            }
                        });
                    </script>

                    <div class="container" id="decryptForm" style="display: none;">
                        <h2 class="text-center mb-4">Decryption</h2>
                        <form action="rc4.php" method="post" enctype="multipart/form-data" id="rc4-form" autocomplete="off">
                            <div class="mb-4">
                                <label for="decryptionKey" class="form-label">Decryption Key</label>
                                <input type="password" class="form-control" id="decryptionKey" placeholder="gunakan key yang sama pada saat encrypt" name="decryptionKey" required>
                            </div>
                            <div class="mb-4">
                                <label for="fileToDecrypt" class="form-label">File to Decrypt</label>
                                <input type="file" class="form-control" id="fileToDecrypt" name="fileToDecrypt" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="decrypt" id="decryptBtn" disabled>Decrypt</button>
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#infoModal" style="float: right">
                                <i class="fas fa-question-circle"></i> Help
                            </a>
                        </form>
                    </div>

                    <script>
                        const decryptionKeyInput = document.getElementById('decryptionKey');
                        const fileToDecryptInput = document.getElementById('fileToDecrypt');
                        const decryptBtn = document.getElementById('decryptBtn');

                        decryptionKeyInput.addEventListener('input', () => {
                            if (decryptionKeyInput.value.length >= 8 && fileToDecryptInput.files.length > 0) {
                                decryptBtn.disabled = false;
                            } else {
                                decryptBtn.disabled = true;
                            }
                        });

                        fileToDecryptInput.addEventListener('input', () => {
                            if (decryptionKeyInput.value.length >= 8 && fileToDecryptInput.files.length > 0) {
                                decryptBtn.disabled = false;
                            } else {
                                decryptBtn.disabled = true;
                            }
                        });
                    </script>
                </section>
                <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModalLabel">Guide</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>ENCRYPT</label>
                                <ul>
                                    <li>Pilih file yang ingin di-encrypt</li>
                                    <li>Buat Password (minimal 8 karakter)</li>
                                    <li>Klik Encrypt</li>
                                    <li>Selesai</li>
                                </ul>
                                <br><br>
                                <label>DECRYPT</label>
                                <ul>
                                    <li>Pilih file yang ingin di-decrypt</li>
                                    <li>Masukan password yang sama seperti saat encrypt</li>
                                    <li>Klik Decrypt</li>
                                    <li>Selesai</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var dataencryptMenu = document.getElementById("dataencryptMenu");
            var userMenu = document.getElementById("userMenu");
            var userTable = document.getElementById("table-user");
            var encryptTable = document.getElementById("table-enkripsi");
            var encryptForm = document.getElementById("encryptForm");
            var encryptMenu = document.getElementById("encryptMenu");

            encryptTable.classList.add("hide-table");
            encryptForm.style.display = "none";
            decryptForm.style.display = "none";

            dataencryptMenu.addEventListener("click", function() {
                userTable.classList.add("hide-table");
                encryptTable.classList.remove("hide-table");
                encryptForm.style.display = "none";
                decryptForm.style.display = "none";

                dataencryptMenu.classList.add("active");
                userMenu.classList.remove("active");
                encryptMenu.classList.remove("active");
                decryptMenu.classList.remove("active");
            });

            userMenu.addEventListener("click", function() {
                encryptTable.classList.add("hide-table");
                userTable.classList.remove("hide-table");
                encryptForm.style.display = "none";
                decryptForm.style.display = "none";

                userMenu.classList.add("active");
                dataencryptMenu.classList.remove("active");
                encryptMenu.classList.remove("active");
                decryptMenu.classList.remove("active");
            });

            encryptMenu.addEventListener("click", function() {
                encryptTable.classList.add("hide-table");
                userTable.classList.add("hide-table");
                encryptForm.style.display = "block";
                decryptForm.style.display = "none";

                encryptMenu.classList.add("active");
                userMenu.classList.remove("active");
                dataencryptMenu.classList.remove("active");
                decryptMenu.classList.remove("active");
            });

            decryptMenu.addEventListener("click", function() {
                encryptTable.classList.add("hide-table");
                userTable.classList.add("hide-table");
                encryptForm.style.display = "none";
                decryptForm.style.display = "block";

                decryptMenu.classList.add("active");
                userMenu.classList.remove("active");
                dataencryptMenu.classList.remove("active");
                encryptMenu.classList.remove("active");
            });
        </script>
    </div>
    <link rel="stylesheet" href="css/superadminpage.css">
</body>

</html>