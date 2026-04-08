<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$projects = json_decode(file_get_contents("../../data/projects.json"), true);
$found = false;

foreach ($projects as $key => $p) {
    if ($p['id'] == $id) {
        // Borrar imágenes asociadas
        if (!empty($p['images'])) {
            foreach ($p['images'] as $img) {
                $filePath = "../" . ltrim($img, '/');
                if (file_exists($filePath)) unlink($filePath);
            }
        }

        // Borrar del array
        unset($projects[$key]);
        $found = true;
        break;
    }
}

if ($found) {
    $projects = array_values($projects); // reindexar
    file_put_contents("../../data/projects.json", json_encode($projects, JSON_PRETTY_PRINT), LOCK_EX);
}

header("Location: dashboard.php");
exit;

