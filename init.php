<?php
$configFile = 'config.php';
if (!file_exists($configFile) || empty(json_decode(file_get_contents($configFile), true))) {
    header("Location: setup.php");
    exit;
}
include 'config.php';
