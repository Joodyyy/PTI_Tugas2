<?php
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $nim = $nama = $jurusan = $error = "";

// Jika ada parameter ID, artinya mode UPDATE (Ambil data lama)
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nim = $row['nim'];
        $nama = $row['nama'];
        $jurusan = $row['jurusan'];
    }
}

// Proses form disubmit (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input menggunakan htmlspecialchars untuk mencegah XSS
    $nim_post = htmlspecialchars(trim($_POST['nim']));
    $nama_post = htmlspecialchars(trim($_POST['nama']));
    $jurusan_post = htmlspecialchars(trim($_POST['jurusan']));

    // Struktur Kontrol Validasi Kelengkapan Data
    if (empty($nim_post) || empty($nama_post) || empty($jurusan_post)) {
        $error = t('error_empty');
    } else {
        if (!empty($_POST['id'])) {
           
            $id_post = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $stmt = $conn->prepare("UPDATE mahasiswa SET nim=?, nama=?, jurusan=? WHERE id=?");
            $stmt->bind_param("sssi", $nim_post, $nama_post, $jurusan_post, $id_post);
        } else {
            
            $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nim_post, $nama_post, $jurusan_post);
        }
        
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Form <?= t('title') ?></title></head>
<body>
    <h2>Form <?= t('title') ?></h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="">
       
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        
        <label>NIM:</label><br>
        <input type="text" name="nim" value="<?= htmlspecialchars($nim) ?>"><br><br>
        
        <label><?= t('name') ?>:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>"><br><br>
        
        <label><?= t('major') ?>:</label><br>
        <input type="text" name="jurusan" value="<?= htmlspecialchars($jurusan) ?>"><br><br>
        
        <button type="submit"><?= t('save') ?></button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>