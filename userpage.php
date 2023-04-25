<?php
session_start();

// Include database connection file
include_once('config.php');

if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
} else {
    $user_role = $_SESSION['ROLE'];
    if ($user_role != 'user') {
        header("Location:unauthorized.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title class="text">RC4 User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-Y0fJIxUZ0xUZvmqXu93pVmkWfetG/l7VUsnkOnTQ2PZnRnZlL21eLLch9XvY1tSggzKyH2yMhB4rlvG4ln4wfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://wowjs.netlify.app/dist/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</head>

<body style="background-image: url('img/background.svg');">
    <script>
        AOS.init();
    </script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed top sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/navbar.png" alt="Brand logo" class="navbar-brand-img mx-auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link ripple active" href="#" onclick="scrollToTop()" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" id="encryptMenu">Encrypt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ripple" href="#" onclick="scrollToTop()" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" id="decryptMenu">Decrypt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ripple" href="#about" onclick="$('.navbar-collapse').collapse('hide')" id="aboutMenu">About</a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-logout" onclick="location.href='logout.php'" title="Logout">
                <img src="icon/logout.svg" alt="Logout" width="16" height="16">
            </button>
        </div>
    </nav>

    <section id="formCont">
        <div class="container" data-aos="fade-up" id="encryptForm">
            <h2 class="text-center mb-4 animate__animated animate__wobble">Encryption</h2>
            <form action="rc4.php" method="post" enctype="multipart/form-data" id="rc4-form">
                <div class="mb-4">
                    <label for="encryptionKey" class="form-label animate__animated animate__wobble">Encryption Key</label>
                    <input type="password" class="form-control" id="encryptionKey" placeholder="minimal 8 karakter" name="encryptionKey" required>
                </div>
                <div class="mb-4">
                    <label for="fileToEncrypt" class="form-label animate__animated animate__wobble">File to Encrypt</label>
                    <input type="file" class="form-control" id="fileToEncrypt" name="fileToEncrypt" required>
                </div>
                <button type="submit" class="btn btn-primary animate__animated animate__wobble" name="encrypt" id="encryptBtn" disabled>Encrypt</button>
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

        <div class="container" data-aos="fade-up" id="decryptForm">
            <h2 class="text-center mb-4 animate__animated animate__wobble">Decryption</h2>
            <form action="rc4.php" method="post" enctype="multipart/form-data" id="rc4-form">
                <div class="mb-4">
                    <label for="decryptionKey" class="form-label animate__animated animate__wobble">Decryption Key</label>
                    <input type="password" class="form-control" id="decryptionKey" placeholder="gunakan key yang sama pada saat encrypt" name="decryptionKey" required>
                </div>
                <div class="mb-4">
                    <label for="fileToDecrypt" class="form-label animate__animated animate__wobble">File to Decrypt</label>
                    <input type="file" class="form-control" id="fileToDecrypt" name="fileToDecrypt" required>
                </div>
                <button type="submit" class="btn btn-primary animate__animated animate__wobble" name="decrypt" id="decryptBtn" disabled>Decrypt</button>
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

        <script>
            // sembunyikan form decrypt saat halaman dimuat
            $(document).ready(function() {
                $("#decryptForm").hide();
            });

            // ketika menu Encrypt di-klik, sembunyikan form Decrypt dan tampilkan form Encrypt
            $("#encryptMenu").click(function() {
                $("#decryptForm").hide();
                $("#encryptForm").show();
                encryptMenu.classList.add("active");
                aboutMenu.classList.remove("active");
                decryptMenu.classList.remove("active");
            });

            // ketika menu Decrypt di-klik, sembunyikan form Encrypt dan tampilkan form Decrypt
            $("#decryptMenu").click(function() {
                $("#encryptForm").hide();
                $("#decryptForm").show();
                decryptMenu.classList.add("active");
                aboutMenu.classList.remove("active");
                encryptMenu.classList.remove("active");
            });

            $("#aboutMenu").click(function() {
                aboutMenu.classList.add("active");
                encryptMenu.classList.remove("active");
                decryptMenu.classList.remove("active");
            });
        </script>
    </section>

    <section id="about">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="section-heading mb-3 text-white" data-aos="fade-down" data-aos-anchor-placement="center-bottom">About Us</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="box3 about-content p-5 rounded shadow" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
                        <h2 class="mb-3 text-center">Our Mission</h2>
                        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="row flex-md-row">
                <div class="col-md-6 mb-5 order-md-1 order-2">
                    <div class="box1 about-content p-5 rounded shadow" data-aos="fade-up" data-aos-anchor-placement="bottom-mid">
                        <h2 class="mb-3 text-center">Universitas Budi Luhur</h2>
                        <img class="img-fluid mb-4 mx-auto d-block" src="./img/logoBL.png" alt="Universitas Budi Luhur" style="width:100px">
                        <p>Cerdas dan berbudi luhur merupakan dua hal yang terpadu yang tidak terpisahkan, karena kecerdasan tanpa dilandasi budi yang luhur akan cenderung digunakan untuk membodohi dan mencelakakan orang lain, sebaliknya budi luhur tanpa diimbangi kecerdasan akan merupakan sasaran kejahatan dan penindasan dari orang lain.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 order-md-2 order-1">
                    <div class="row flex-md-row">
                        <div class="box2 col-md-12 mb-4">
                            <div class="about-content p-5 rounded shadow" data-aos="fade-up" data-aos-anchor-placement="bottom-mid">
                                <h2 class="mb-3 text-center">SMK Media Informatika</h2>
                                <img class="img-fluid mb-4 mx-auto d-block" src="./img/metik.png" alt="SMK Media Informatika" style="width:100px">
                                <p>SMK Media Informatika adalah sekolah SMK pertama di Jakarta Selatan yang bergerak dalam bidang Teknologi Informasi. SMK Media Informatika juga memiliki tag line "Sekolah Berbasis Project" dimana siswa dipersiapkan untuk menghadapi dunia usaha dan dunia kerja melalui pembelajaran berbasis project.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Information</h5>
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

    <footer class="bg-light text-center text-lg-start" style="background-image: url('img/background.svg');">
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

    <link rel="stylesheet" href="css/index.css">
</body>

</html>