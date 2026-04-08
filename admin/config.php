<?php
session_start();
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true){
    header("Location: login.php");
    exit;
}

$configFile = '../../data/config.json';
$config = json_decode(file_get_contents($configFile), true);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['title'] = $_POST['title'];
    $config['subtitle'] = $_POST['subtitle'];
    $config['name'] = $_POST['name'];
    $config['skills'] = $_POST['skills'];
    $config['experience'] = $_POST['experience'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
	$uploadDir = __DIR__ . '/../assets/img/';
	if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
	$filePath = $uploadDir . basename($_FILES['profile_image']['name']);
	move_uploaded_file($_FILES['profile_image']['tmp_name'], $filePath);
	$config['profile_image'] = '/assets/img/' . basename($_FILES['profile_image']['name']);
    }


    if (!empty($_POST['password'])) {
        $config['admin_pass'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    $message = "✅ Configuración actualizada";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Config Admin - <?= htmlspecialchars($config['title']) ?></title>
    <link rel="stylesheet" href="../assets/style.css" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'media',
    theme: {
      extend: {
colors: {
        'primary': 'var(--color-primary)',
        'primary-hover': 'var(--color-primary-hover)',
        'bg': 'var(--color-bg)',
        'secondary-bg': 'var(--color-secondary-bg)',
        'secondary-bg-dark': 'var(--color-secondary-bg-dark)',
        'text-main': 'var(--color-text)',
        'text-secondary': 'var(--color-text-secondary)'
      },	
      },
    }
  }
</script>
</head>
<body class="bg-bg text-text-main  min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-secondary-bg rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Editar Configuración</h1>

        <?php if($message): ?>
            <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 p-3 rounded mb-6 text-center">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <form method="post" class="space-y-4" enctype="multipart/form-data">
            <div>
                <label class="block font-semibold mb-1">Título de la página</label>
                <input type="text" name="title" value="<?= htmlspecialchars($config['title']) ?>"
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
	    <div>
                <label class="block font-semibold mb-1">Nombre Completo</label>
                <input type="text" name="name" value="<?= htmlspecialchars($config['name']) ?>"
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block font-semibold mb-1">Subtítulo</label>
                <input type="text" name="subtitle" value="<?= htmlspecialchars($config['subtitle']) ?>"
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-secondary dark:text-text-secondary-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div> 
	    <div>
		<label class="block font-semibold mb-1">Imagen de perfil</label>
		<input type="file" name="profile_image" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
		<?php if(!empty($config['profile_image'])): ?>
			<img src="<?= $config['profile_image'] ?>" alt="Perfil" class="mt-2 w-24 h-24 rounded-full object-cover border border-primary">
		<?php endif; ?>
	    </div>

	 <div>
		<label class="block font-semibold mb-1">Habilidades</label>
		<textarea name="skills" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary"><?php if(!empty($config['skills']))echo($config['skills']);?></textarea>
		
	    </div>
	    <div>
		<label class="block font-semibold mb-1">Experiencia</label>
		<textarea name="experience" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary"><?php if(!empty($config['experience']))echo($config['experience']);?></textarea>

	    </div>


            <div>
                <label class="block font-semibold mb-1">Contraseña admin</label>
                <input type="password" name="password" placeholder="Dejar vacío para no cambiar"
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded-lg font-semibold transition">
                Guardar cambios
            </button>
        </form>
    </div>
</body>
</html>

