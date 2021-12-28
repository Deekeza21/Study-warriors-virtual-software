<?php

$dbusername = '3928563_edouinadb';
$dbpassword = 'Gitarama63@';
$host = 'fdb34.awardspace.net';
$dbname = '3928563_edouinadb';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}