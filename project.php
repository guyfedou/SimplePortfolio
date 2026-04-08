<?php include "../templates/header.php"; ?>

<?php
$projects = json_decode(file_get_contents("../data/projects.json"), true);
$id = $_GET["id"] ?? null;
$project = null;

foreach ($projects as $p) {
    if ($p["id"] == $id) $project = $p;
}

if (!$project) {
    echo "<p>Proyecto no encontrado.</p>";
    include "../templates/footer.php";
    exit;
}
?>

<h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100"><?= $project['title'] ?></h2>
<p class="mb-6 text-gray-700 dark:text-gray-300"><?= $project['content'] ?></p>

<?php if (!empty($project['images'])): ?>
<div class="flex overflow-x-auto gap-4 mb-6">
    <?php foreach ($project['images'] as $img): ?>
        <img src="<?= $img ?>" class="h-48 object-cover rounded-xl flex-shrink-0" alt="<?= $project['title'] ?>">
    <?php endforeach; ?>
</div>
<?php endif; ?>

<a href="/" class="text-blue-600 dark:text-blue-400 underline">Volver</a>
<?php include "../templates/footer.php"; ?>

