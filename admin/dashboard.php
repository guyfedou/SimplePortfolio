<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit;
}

$projects = json_decode(file_get_contents("../../data/projects.json"), true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'media', theme: { extend: {} } }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-8 transition-colors duration-500">

<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <div class="flex gap-4 mb-6">
        <a href="add-project.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Añadir proyecto</a>
        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">Cerrar sesión</a>
        <a href="config.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">Ajustes</a>
    </div>

    <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-800">
                <th class="border p-2">ID</th>
                <th class="border p-2">Título</th>
                <th class="border p-2">Resumen</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $p): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="border p-2"><?= $p["id"] ?></td>
                    <td class="border p-2"><?= $p["title"] ?></td>
                    <td class="border p-2"><?= $p["summary"] ?></td>
                    <td class="border p-2 flex gap-2">
                        <a href="edit-project.php?id=<?= $p['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded transition">Editar</a>
                        <a href="delete-project.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Estás seguro de borrar este proyecto?')" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

