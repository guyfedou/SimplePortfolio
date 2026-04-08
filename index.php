<?php
$configFile = __DIR__ . '/../data/config.json';
if (!file_exists($configFile) || empty(json_decode(file_get_contents($configFile), true))) {
    header("Location: setup.php");
    exit;
}

 include "../templates/header.php"; ?>

<!-- HERO -->
<section class="mb-8 text-center text-text">
    <h1 class="text-5xl font-bold mb-4"><?=htmlspecialchars($config['name'])?></h1>
	<div class="flex-1 flex justify-center mb-4">
            <img src="<?=htmlspecialchars($config['profile_image'])?>" alt="<?=htmlspecialchars($config['name'])?>" class="w-48 h-48 md:w-64 md:h-64 rounded-full object-cover shadow-lg border-4 border-primary">
        </div>
    <p class="text-xl mb-6 text-text-secondary dark:text-text-secondary"><?=htmlspecialchars($config['subtitle'])?></p>
    <a href="#proyectos" class="inline-block bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-lg transition">
        Ver mis proyectos
    </a>
</section>

<!-- SOBRE MÍ / HABILIDADES -->
<section class="py-20 px-4 mb-4 rounded-xl bg-secondary-bg-dark text-text">
    <h2 class="text-3xl font-bold mb-12 text-center"><?= "Sobre mí" ?></h2>
    <div class="max-w-4xl mx-auto grid gap-8 md:grid-cols-2">
        <div class="p-6 rounded-xl shadow hover:shadow-lg bg-secondary-bg text-text">
            <h3 class="text-xl font-semibold mb-2"><?= "Habilidades" ?></h3>
          
<?= preg_replace('/&lt;(\/?(strong|b|i|li|ul|br))&gt;/', '<$1>', htmlentities($config['skills']));
?>
        </div>
        <div class="p-6 rounded-xl shadow hover:shadow-lg bg-secondary-bg text-text">
            <h3 class="text-xl font-semibold mb-2"><?= "Experiencia" ?></h3>
            <p class="opacity-90">
                He trabajado en proyectos personales y colaborativos, creando aplicaciones web, páginas dinámicas y portfolios personalizados para mostrar trabajos de manera profesional.
            </p>
        </div>
    </div>
</section>

<!-- PROYECTOS -->
<section id="proyectos" class="py-20 px-4 bg-bg text-text">
    <h2 class="text-3xl font-bold mb-12 text-center"><?= "Mis Proyectos" ?></h2>

    <?php
    $projects = json_decode(file_get_contents("../data/projects.json"), true);

    if (!$projects) {
        echo "<p class='text-center text-text-secondary'>No hay proyectos aún.</p>";
    } else {
        echo '<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">';
        foreach ($projects as $p) {
            $thumb = isset($p['images'][0]) ? $p['images'][0] : '/assets/img/placeholder.png';

            echo "
            <a href='/project.php?id={$p['id']}' class='block rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow hover:shadow-lg'>
                <img src='{$thumb}' alt='{$p['title']}' class='w-full h-48 object-cover'>
                <div class='p-5'>
                    <h3 class='font-semibold text-xl mb-2'>{$p['title']}</h3>
                    <p class='opacity-90'>{$p['summary']}</p>
                </div>
            </a>
            ";
        } 
        echo "</div>";
    }
    ?>
</section>

<!-- CONTACTO -->
<section class="py-20 text-center rounded-xl bg-secondary-bg text-text">
    <h2 class="text-3xl font-bold mb-4"><?= "¿Quieres trabajar conmigo?" ?></h2>
    <p class="opacity-90 mb-6 text-text-secondary">
        Si te interesa colaborar o tienes un proyecto, ¡hablemos!
    </p>
    <a href="mailto:hola@tudominio.dev" class="inline-block bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-lg transition">
        Contactame
    </a>
</section>

<?php include "../templates/footer.php"; ?>

