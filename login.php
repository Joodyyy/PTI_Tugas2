<?php
require 'config.php';

// Jika sudah login, arahkan ke index
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input form login
    $username = htmlspecialchars($_POST['username']);
    $password = md5($_POST['password']); 

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title><?= t('login') ?></title></head>
<body>
    <div align="center">
        <!-- Pilihan Bahasa -->
        <a href="?lang=id">Indonesia</a> | <a href="?lang=en">English</a>
        
        <h2><?= t('login') ?></h2>
        <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
        
        <form method="POST" action="">
            <label><?= t('username') ?>:</label><br>
            <input type="text" name="username" required><br><br>
            
            <label><?= t('password') ?>:</label><br>
            <input type="password" name="password" required><br><br>
            
            <button type="submit"><?= t('login') ?></button>
        </form>
    </div>
</body>
</html>