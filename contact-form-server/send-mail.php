<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обработка preflight запроса
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Проверяем метод
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit();
}

// Получаем данные
$input = json_decode(file_get_contents('php://input'), true);

// Если не получилось распарсить JSON, пробуем form-data
if (!$input) {
    $input = $_POST;
}

// Валидация
$name = trim($input['name'] ?? '');
$phone = trim($input['phone'] ?? '');
$email = trim($input['email'] ?? '');
$object_type = trim($input['object_type'] ?? '');
$message = trim($input['message'] ?? '');

// Проверка обязательных полей
if (empty($name) || empty($phone)) {
    echo json_encode([
        'success' => false,
        'message' => 'Имя и телефон обязательны'
    ]);
    exit();
}

// Настройки почты
$to = "kovalev.vova@list.ru"; // Ваша почта
$subject = "Новая заявка с сайта РПСС";

// Текст письма
$emailMessage = "
НОВАЯ ЗАЯВКА С САЙТА РПСС

Имя: $name
Телефон: $phone
" . ($email ? "Email: $email\n" : "") . "
Тип объекта: " . ($object_type ?: 'Не указан') . "
" . ($message ? "Сообщение:\n$message\n" : "") . "
Дата: " . date('d.m.Y H:i:s') . "
IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'неизвестен') . "
";

// Заголовки
$headers = "From: site@rpss.ru\r\n";
$headers .= "Reply-To: " . ($email ?: "kovalev.vova@list.ru") . "\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

// Отправка письма
if (mail($to, $subject, $emailMessage, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => 'Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Ошибка при отправке заявки. Пожалуйста, позвоните нам по телефону.'
    ]);
}
?>