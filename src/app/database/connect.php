<?php

$driver = 'mysql';
$host = 'localhost';
if ($_SERVER['DOCUMENT_ROOT'] == '/Applications/XAMPP/xamppfiles/hosts/cashier-workplace/src/') {
    $db_name = 'smile';
    $db_user = 'root';
    $db_pass = '';
} elseif ($_SERVER['DOCUMENT_ROOT'] == '/Applications/XAMPP/xamppfiles/htdocs') {
    $db_name = 'smile';
    $db_user = 'root';
    $db_pass = '';
} else {
    $db_name = 'admin_smile';
    $db_user = 'admin_smile';
    $db_pass = 'Q!w2e3r4t5';
}
$charset = 'utf8';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO(
        "$driver:host=$host;dbname=$db_name;charset=$charset",
        $db_user,
        $db_pass,
        $options
    );
} catch (PDOException $if) {
    die('Error connect DB');
}
