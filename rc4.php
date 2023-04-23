<?php
// Memulai session

session_start();
include_once('config.php');

if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    die();
}

// Set memory limit for the script
ini_set('memory_limit', '256M');
// RC4 encryption function
function rc4($key, $data)
{
    // Convert key and data to arrays of bytes
    $key = array_values(unpack('C*', $key));
    $data = array_values(unpack('C*', $data));
    $result = '';
    $s = array();

    // Initialize the state array with values from 0 to 255
    for ($i = 0; $i < 256; $i++) {
        $s[$i] = $i;
    }

    // Key-scheduling algorithm
    $j = 0;
    $len = count($key);
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + $key[$i % $len]) % 256;
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;
    }

    // Pseudo-random generation algorithm
    $i = 0;
    $j = 0;
    $len = count($data);
    for ($k = 0; $k < $len; $k++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;

        // XOR the byte of data with a byte from the state array
        $result .= chr($data[$k] ^ $s[($s[$i] + $s[$j]) % 256]);
    }
    // Return the encrypted/decrypted data
    return $result;
}


function is_valid_key($key)
{
    // Cek panjang key harus minimal 8 karakter
    if (strlen($key) < 8) {
        return false;
    }
    return true;
}

if (isset($_POST['encrypt'])) {
    $encryptionKey = $_POST['encryptionKey'];

    // Cek apakah key memenuhi syarat
    if (!is_valid_key($encryptionKey)) {
        echo '<script>alert("Encryption Key Minimal 8 Karakter");window.location.href = "index.php";</script>';
    } else if (!isset($_FILES['fileToEncrypt']['tmp_name']) || empty($_FILES['fileToEncrypt']['tmp_name'])) {
        // Cek apakah file telah diinput
        echo '<script>alert("Mohon pilih file yang akan dienkripsi.");window.location.href = "index.php";</script>';
    } else {
        $fileToEncrypt = $_FILES['fileToEncrypt']['tmp_name'];
        $fileName = basename($_FILES["fileToEncrypt"]["name"]);
        $encryptedFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        // Baca file yang akan dienkripsi
        $data = file_get_contents($fileToEncrypt);

        // Enkripsi data menggunakan algoritma RC4
        $encryptedData = rc4($encryptionKey, $data);

        // Simpan data yang telah dienkripsi ke dalam file di direktori lokal
        $localDir = 'D:/RC4/soal ujian/';
        if (!file_exists($localDir)) {
            mkdir($localDir, 0777, true);
        }
        $encryptedFilePath = $localDir . $encryptedFileName;
        file_put_contents($encryptedFilePath, $encryptedData);

        // Simpan nama file, password enkripsi, dan username ke dalam tabel files di dalam database
        $encryptedFileNameInDB = mysqli_real_escape_string($con, $encryptedFileName);
        $encryptionKeyInDB = mysqli_real_escape_string($con, $encryptionKey);
        $usernameInDB = mysqli_real_escape_string($con, $_SESSION['NAME']);

        $query = "INSERT INTO files (file_name, encryption_key, username) VALUES ('$encryptedFileNameInDB', '$encryptionKeyInDB', '$usernameInDB')";
        mysqli_query($con, $query);
        mysqli_close($con);


        // Redirect ke halaman sukses
        echo '<script>alert("File berhasil dienkripsi dan disimpan di direktori ' . $localDir . '");window.location.href = "index.php";</script>';
    }
}


if (isset($_POST['decrypt'])) {
    $decryptionKey = $_POST['decryptionKey'];

    // Cek apakah key memenuhi syarat
    if (!is_valid_key($decryptionKey)) {
        echo '<script>alert("Decryption Key Minimal 8 Karakter, 1 Huruf Kapital dan 1 Angka..");window.location.href = "index.php"</script>';
    } else {
        $fileToDecrypt = $_FILES['fileToDecrypt']['tmp_name'];
        $fileName = basename($_FILES["fileToDecrypt"]["name"]);
        $decryptedFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

        // Baca file yang akan didekripsi
        $data = file_get_contents($fileToDecrypt);

        // Dekripsi data menggunakan algoritma RC4
        $decryptedData = rc4($decryptionKey, $data);

        // Simpan file yang telah didekripsi ke dalam direktori lokal
        $localDir = 'D:/RC4/soal ujian/';
        $decryptedFilePath = $localDir . $decryptedFileName;
        file_put_contents($decryptedFilePath, $decryptedData);

        // Redirect ke halaman sukses
        echo '<script>alert("File berhasil didekripsi dan disimpan di direktori ' . $localDir . '");window.location.href = "index.php";</script>';
    }
}
