дификация файла messages.php
Замените начало вашего файла messages.php на:

php
<?php
require_once 'config.php';

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $service = $_POST['service'] ?? 'other';

    // Валидация данных (оставьте ваш текущий код валидации)

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO feedback (name, email, message, service) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $message, $service]);
            
            header('Location: thank-you.html');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Ошибка при сохранении данных: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
    <style>
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="contact-form">
        <h3>Форма обратной связи</h3>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="feedback-form" method="POST" action="messages.php">
            <div class="form-group">
                <label for="name">Ваше имя:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Ваш email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Сообщение:</label>
                <textarea id="message" name="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="service">Интересующий курс:</label>
                <select id="service" name="service">
                    <option value="ege" <?php echo (isset($service) && $service === 'ege') ? 'selected' : ''; ?>>Подготовка к ЕГЭ</option>
                    <option value="oge" <?php echo (isset($service) && $service === 'oge') ? 'selected' : ''; ?>>Подготовка к ОГЭ</option>
                    <option value="school" <?php echo (isset($service) && $service === 'school') ? 'selected' : ''; ?>>Школьная программа</option>
                    <option value="other" <?php echo (isset($service) && $service === 'other') ? 'selected' : ''; ?>>Другое</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Отправить</button>
        </form>
    </div>
</body>
</html>