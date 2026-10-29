<?php
session_start();


$host = "localhost";
$user = "root";
$pass = "";
$db   = "dbkampus";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}


if (isset($_GET['lang'])) {
    // Validasi input bahasa
    $lang_input = $_GET['lang'];
    if($lang_input == 'id' || $lang_input == 'en') {
        $_SESSION['lang'] = $lang_input;
    }
}

// Set bahasa 
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'id';

// Kamus 
$dict = [
    'id' => [
        'title' => 'Manajemen Data Mahasiswa',
        'login' => 'Masuk',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'add' => 'Tambah Data',
        'name' => 'Nama',
        'major' => 'Jurusan',
        'action' => 'Aksi',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
        'logout' => 'Keluar',
        'save' => 'Simpan',
        'error_empty' => 'Semua kolom harus diisi!'
    ],
    'en' => [
        'title' => 'Student Data Management',
        'login' => 'Login',
        'username' => 'Username',
        'password' => 'Password',
        'add' => 'Add Data',
        'name' => 'Name',
        'major' => 'Major',
        'action' => 'Action',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'logout' => 'Logout',
        'save' => 'Save',
        'error_empty' => 'All fields are required!'
    ]
];

// Fungsi bantuan untuk memanggil teks sesuai bahasa
function t($key) {
    global $dict, $lang;
    return $dict[$lang][$key];
}
?>