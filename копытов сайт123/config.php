<?php
$host = 'localhost'; // Адрес сервера MySQL
$dbname = 'feedback_db'; // Имя вашей базы данных
$username = 'root'; // Имя пользователя MySQL (по умолчанию 'root')
$password = ''; // Пароль (оставьте пустым, если не устанавливали)

// Параметры подключения
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>