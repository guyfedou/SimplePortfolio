<?php
$configFile = 'config.php';
if (!file_exists($configFile) ) {
    header("Location: setup.php");
    exit;
}
require 'db.php';

$db = new DB();
$projects = $db->get_all();
