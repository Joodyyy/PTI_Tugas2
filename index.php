<?php
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Fitur Hapus (Delete)
if (isset($_GET['delete'])) {
    // Sanitasi ID
    $id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Ambil semua data (Read)
$mahasiswa = $conn->query("SELECT * FROM mahasiswa ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title><?= t('title') ?></title></head>
<body>
    <div style="float: right;">
        <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a> | 
        <a href="logout.php" style="color:red;"><?= t('logout') ?></a>
    </div>

    <h2><?= t('title') ?></h2>
    <a href="form.php"><?= t('add') ?></a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th><?= t('name') ?></th>
            <th><?= t('major') ?></th>
            <th><?= t('action') ?></th>
        </tr>
        <?php 
        $no = 1;
        while ($row = $mahasiswa->fetch_assoc()): 
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nim']) ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['jurusan']) ?></td>
            <td>
                <a href="form.php?id=<?= $row['id'] ?>"><?= t('edit') ?></a> | 
                <a href="index.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin?');"><?= t('delete') ?></a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>