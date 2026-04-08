<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $projects = json_decode(file_get_contents("../../data/projects.json"), true) ?: [];

    // Crear un nuevo proyecto
    $newProject = [
        "id" => time(),
        "title" => $_POST["title"],
        "summary" => $_POST["summary"],
        "content" => $_POST["content"],
        "images" => []
    ];

    // Carpeta donde se guardarán las imágenes
    $uploadDir = "../assets/img/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // Manejar imágenes subidas
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $name) {
            $tmpName = $_FILES['images']['tmp_name'][$key];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = "project_{$newProject['id']}_{$key}." . $ext;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($tmpName, $destination)) {
                $newProject['images'][] = "/assets/img/" . $filename;
            }
        }
    }

    // Agregar proyecto al array y guardar en JSON
    $projects[] = $newProject;
    file_put_contents("../../data/projects.json", json_encode($projects, JSON_PRETTY_PRINT), LOCK_EX);
    $message = "Proyecto añadido correctamente!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Proyecto - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'media', theme: { extend: {} } }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-8 transition-colors duration-500">

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Añadir Proyecto</h1>

    <?php if($message): ?>
        <p class="text-green-600 mb-4"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="title" placeholder="Título"
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
        <input type="text" name="summary" placeholder="Resumen corto"
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
        <textarea name="content" placeholder="Descripción completa"
                  class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" rows="5" required></textarea>

        <label class="block text-gray-900 dark:text-gray-100">Imágenes del proyecto (múltiples)</label>
        <input type="file" name="images[]" multiple
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600">

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded transition">
            Añadir proyecto
        </button>
    </form>

    <a href="dashboard.php" class="inline-block mt-4 text-blue-600 dark:text-blue-400 hover:underline">Volver al dashboard</a>
</div>

</body>
</html>

