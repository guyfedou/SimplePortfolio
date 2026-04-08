<?php
$configFile = 'data/config.json';
if (!file_exists($configFile) || empty(json_decode(file_get_contents($configFile), true))) {
    header("Location: setup.php");
    exit;
}
$config = json_decode(file_get_contents($configFile), true);
