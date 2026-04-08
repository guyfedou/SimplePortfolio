<?php
$configFile = '../data/config.json';
$config = json_decode(file_get_contents($configFile), true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($config['title'])?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/style.css" type="text/css">
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
<body class="bg-bg dark:bg-bg-dark text-text-main dark:text-text-main-dark">
<header class="w-full py-4 px-8 bg-bg dark:bg-bg-dark text-text-main dark:text-text-main-dark shadow-md flex justify-between items-center sticky top-0 z-50">
    <a href="/" class="text-2xl font-bold"><?=htmlspecialchars($config['title'])?></a>
    <nav class="space-x-6">
        <a href="#proyectos" class="hover:text-primary transition">Proyectos</a>
        <a href="#sobre-mi" class="hover:text-primary transition">Sobre mí</a>
        <a href="contact.php" class="hover:text-primary transition">Contacto</a>
    </nav>
</header>

<main class="max-w-5xl mx-auto px-4 py-4">
