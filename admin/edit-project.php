<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$projects = json_decode(file_get_contents("../../data/projects.json"), true);
$project = null;
foreach ($projects as $key => $p) {
    if ($p['id'] == $id) {
        $project = $p;
        $projectKey = $key;
        break;
    }
}

if (!$project) {
    echo "Proyecto no encontrado";
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Actualizar datos
    $projects[$projectKey]['title'] = $_POST['title'];
    $projects[$projectKey]['summary'] = $_POST['summary'];
    $projects[$projectKey]['content'] = $_POST['content'];

    // Subida de nuevas imágenes
    $uploadDir = "../assets/img/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $keyImg => $name) {
            $tmpName = $_FILES['images']['tmp_name'][$keyImg];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = "project_{$id}_" . time() . "_{$keyImg}." . $ext;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($tmpName, $destination)) {
                $projects[$projectKey]['images'][] = "/assets/img/" . $filename;
            }
        }
    }

    file_put_contents("../../data/projects.json", json_encode($projects, JSON_PRETTY_PRINT), LOCK_EX);
    $message = "Proyecto actualizado correctamente!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'media', theme: { extend: {} } }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-8 transition-colors duration-500">

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Editar Proyecto</h1>

    <?php if($message): ?>
        <p class="text-green-600 mb-4"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="title" value="<?= $project['title'] ?>"
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
        <input type="text" name="summary" value="<?= $project['summary'] ?>"
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
        <textarea name="content"
                  class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                  rows="5" required><?= $project['content'] ?></textarea>

        <label class="block text-gray-900 dark:text-gray-100">Añadir nuevas imágenes</label>
        <input type="file" name="images[]" multiple
               class="w-full p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600">

        <?php if (!empty($project['images'])): ?>
            <p class="text-gray-700 dark:text-gray-300">Imágenes actuales:</p>
            <div class="flex flex-wrap gap-2 mb-4">
                <?php foreach ($project['images'] as $img): ?>
                    <img src="<?= $img ?>" class="h-24 object-cover rounded" alt="Imagen proyecto">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded transition">
            Guardar cambios
        </button>
    </form>

    <a href="dashboard.php" class="inline-block mt-4 text-blue-600 dark:text-blue-400 hover:underline">Volver al dashboard</a>
</div>

</body>
</html>

