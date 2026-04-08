<?php
$configFile = 'config.php';
if (!file_exists($configFile) )) {
    header("Location: setup.php");
    exit;
}
include 'config.php';
