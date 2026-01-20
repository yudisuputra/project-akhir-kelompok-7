<?php
// reset_password.php

require "../config/database.php";
require "../models/User.php";

// koneksi DB
$db = (new Database())->connect();
$userModel = new User($db);

/*
  ============================
  KONFIGURASI RESET
  ============================
*/

// username siswa yang akan direset
$username = "siswa1";

// password baru
$newPassword = "123456";

/*
  ============================
  PROSES RESET
  ============================
*/

// cari user berdasarkan username
$user = $userModel->findByUsername($username);

if (!$user) {
    echo "User tidak ditemukan";
    exit;
}

// reset password (hash otomatis)
$userModel->updatePassword($user['id'], $newPassword);

echo "Password berhasil direset\n";
echo "Username : {$username}\n";
echo "Password : {$newPassword}\n";
