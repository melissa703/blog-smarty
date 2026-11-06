<?php
// Connexion MySQL
$connexion = new mysqli('localhost', 'root', '', 'blog');
if ($connexion->connect_error) {
    die('Erreur de connexion : ' . $connexion->connect_error);
}
$connexion->set_charset('utf8mb4');

// Objet Smarty
require_once 'smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
$smarty->setCacheDir('cache');
$smarty->setConfigDir('configs');
