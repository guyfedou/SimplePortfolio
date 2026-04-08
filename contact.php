<?php
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $messageContent = htmlspecialchars($_POST['message']);

    if (!$name || !$email || !$subject || !$messageContent) {
        $message = "Por favor, completa todos los campos.";
    } else {
	//TODO MAILING

        $message = "✅ Gracias $name, tu mensaje ha sido recibido.";
    }
}

include "../templates/header.php"; ?>



    <section class="text-center py-16">
        <h1 class="text-4xl font-bold mb-4">Contacto</h1>
        <p class="text-text-secondary text-lg">Si quieres trabajar conmigo, envíame un mensaje.</p>
    </section>

    <section class="w-full ">
    <section class="w-full max-w-lg bg-secondary-bg p-8 m-auto rounded-xl shadow-lg">
        <?php if($message): ?>
            <div class="mb-6 p-3 rounded bg-primary text-white text-center">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold">Nombre</label>
                <input type="text" name="name" required
                       class="w-full p-3 rounded-lg border border-gray-300 bg-white text-text-main dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Correo</label>
                <input type="email" name="email" required
                       class="w-full p-3 rounded-lg border border-gray-300 bg-white text-text focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Asunto</label>
                <input type="text" name="subject" required
                       class="w-full p-3 rounded-lg border border-gray-300 bg-white text-text focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Mensaje</label>
                <textarea name="message" rows="5" required
                          class="w-full p-3 rounded-lg border border-gray-300 bg-white text-text focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded-lg font-semibold transition">
                Enviar mensaje
            </button>
        </form>
    </section>
    </section>



<?php include "../templates/footer.php"; ?>

