<?php
require "../config/database.php";
require "../models/User.php";
require "../helpers/response.php";

// Ambil data dari body JSON
$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

// Validasi input kosong
if (!$username || !$password) {
    jsonResponse(["message" => "Username & password masih kosong"], 422);
}

// Koneksi dan cari user
$db = (new Database())->connect();
$userModel = new User($db);
$user = $userModel->findByUsername($username);

// Cek apakah user ditemukan
if (!$user) {
    jsonResponse(["message" => "Username tidak ditemukan"], 404);
}

// Cek password cocok
if (trim($user['password']) !== $password) {
    jsonResponse(["message" => "Wrong password"], 401);
}

// Login sukses
jsonResponse([
    "message" => "Login berhasil",
    "uid" => $user['id'],
    "role" => $user['role'] // pastikan ini ambil nama role, bukan angka
]);
