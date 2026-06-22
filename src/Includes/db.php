<?php
try {
    $mysqlClient = new PDO(
        "mysql:host=localhost;dbname=kzukzu_sherob;charset=utf8mb4",
        "jadnayl",
        "jadnayldb"
    );

    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}