<?php
require_once "../helpers/response.php";

// Simulasi user login (nanti diganti token/session)
$currentUser = [
    "uid" => $_GET['uid'] ?? null,
    "role" => $_GET['role'] ?? null
];

if (!$currentUser['uid'] || !$currentUser['role']) {
    jsonResponse(["message" => "Unauthorized"], 401);
}

