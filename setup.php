<?php
$configFile = 'config.php';
$message = "";

// Si ya existe la configuración, redirigimos o avisamos
if (file_exists($configFile) || !empty(json_decode(file_get_contents($configFile), true))) {
    die("<p class='text-center mt-20 text-red-600'>⚠️ Configuración ya existe. Usa el panel admin para modificarla.</p>");
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $name = $_POST['name'];
    $subtitle = $_POST['subtitle'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db_host = $_POST['db-host'];
    $db_user = $_POST['db-user'];
    $db_name = $_POST['db-name'];
    $db_pass = $_POST['db-pass'];

    if (!$title || !$subtitle || !$username || !$password || !$db_user || !$db_name || !$db_pass ) {
        $message = "Por favor, completa todos los campos.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$config = "<?php
	
	define('TITLE', '$title');
	define('NAME', '$name');
	define('SUBTITLE', '$subtitle');
	define('ADMIN_USER', '$username');
	define('ADMIN_PASS', '$hashedPassword');
	define('profile_image', 'assets/img/placeholder.png');
	
	define('DB_HOST', '$db_host');
	define('DB_USER', '$db_user');
	define('DB_PASS', '$db_pass');
	define('DB_NAME', '$db_name');

	";


        file_put_contents('config.php', $config);
        $message = "✅ Configuración creada correctamente. <a href='admin/login.php' class='text-primary underline'>Ir al login</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Setup Portfolio</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    darkMode: 'media',
    theme: {
        extend: {
            colors: {
                primary: '#2563eb',
                'primary-hover': '#1d4ed8',
                bg: '#ffffff',
                'bg-dark': '#111827',
                'bg-secondary': '#f3f4f6',
                'bg-secondary-dark': '#373737',
                'text-main': '#111827',
                'text-main-dark': '#f9fafb',
                'text-secondary': '#4b5563',
                'text-secondary-dark': '#d1d5db',
            }
        }
    }
}
</script>
</head>
<body class="bg-bg dark:bg-bg-dark text-text-main dark:text-text-main-dark min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-bg-secondary dark:bg-bg-secondary-dark rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Configuración Inicial</h1>

        <?php if($message): ?>
            <div class="mb-6 p-3 rounded <?= strpos($message,'✅')!==false ? 'bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block font-semibold mb-1">Título de la página</label>
                <input type="text" name="title" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
	    <div>
                <label class="block font-semibold mb-1">Nombre Completo</label>
                <input type="text" name="name" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block font-semibold mb-1">Subtítulo</label>
                <input type="text" name="subtitle" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-secondary dark:text-text-secondary-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block font-semibold mb-1">Usuario admin</label>
                <input type="text" name="username" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block font-semibold mb-1">Contraseña admin</label>
                <input type="password" name="password" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block font-semibold mb-1"> Host DB</label>
                <input type="text" name="db-host" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block font-semibold mb-1">Usuario DB</label>
                <input type="text" name="db-user" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block font-semibold mb-1">Nombre DB</label>
                <input type="text" name="db-name" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>


            <div>
                <label class="block font-semibold mb-1">Contraseña DB</label>
                <input type="password" name="db-pass" required
                       class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded-lg font-semibold transition">
                Crear Configuración
            </button>
        </form>
    </div>
</body>
</html>

