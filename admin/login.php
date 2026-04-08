<?php
session_start();

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
        header("Location: dashboard.php");

$config = json_decode(file_get_contents('../../data/config.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    if ($user === $config['admin_user'] && password_verify($pass, $config['admin_pass'])) {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'media', theme: { extend: {} } }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex items-center justify-center h-screen transition-colors duration-500">
    <form method="POST" class="bg-white dark:bg-gray-800 p-8 rounded shadow w-80">
        <h2 class="text-xl font-bold mb-6 text-center">Login Admin</h2>

        <?php if($error): ?>
            <p class="text-red-600 mb-4"><?= $error ?></p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Usuario" class="w-full mb-4 p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full mb-4 p-2 border rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">Entrar</button>
    </form>
</body>
</html>

