<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected'])) {
    // Rediriger vers la page de connexion
    header('Location: connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['index'])) {
    $index = $_GET['index'];
    $tempFile = '../txt/temp.txt';

    if (file_exists($tempFile)) {
        $tempLines = file($tempFile, FILE_IGNORE_NEW_LINES);

        if ($index >= 0 && $index < count($tempLines)) {
            // Supprimer la ligne de temp.txt
            unset($tempLines[$index]);
            file_put_contents($tempFile, implode(PHP_EOL, $tempLines));

            http_response_code(200); // OK
        } else {
            http_response_code(400); // Bad Request
        }
    } else {
        http_response_code(500); // Internal Server Error
    }
} else {
    http_response_code(400); // Bad Request
}
