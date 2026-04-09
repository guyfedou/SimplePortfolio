<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$configFile = 'config.php';
if (!file_exists($configFile) ) {
    header("Location: setup.php");
    exit;
}
require 'db.php';

$db = new DB();
$projects = $db->getAll();

var_dump(__DIR__);
var_dump($db->getAllConfig());
