<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/NilaiController.php";

// SISWA ONLY
if ($currentUser['role'] !== 'siswa') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new NilaiController($db);

$method = $_SERVER['REQUEST_METHOD'];
$siswaId = $_GET['id'] ?? null; // id siswa dari query

switch ($method) {
    case "GET":
        if (!$siswaId) {
            jsonResponse(["message" => "ID siswa diperlukan"], 422);
        }
        // siswa hanya bisa lihat nilai miliknya
        $controller->show($siswaId);
        break;
    default:
        jsonResponse(["message" => "Method not allowed"], 405);
}
