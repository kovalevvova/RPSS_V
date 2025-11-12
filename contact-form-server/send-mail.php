<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$name = trim($input['name'] ?? '');
$phone = trim($input['phone'] ?? '');
$email = trim($input['email'] ?? '');
$object_type = trim($input['object_type'] ?? '');
$message = trim($input['message'] ?? '');

if (empty($name) || empty($phone)) {
    echo json_encode([
        'success' => false,
        'message' => 'Имя и телефон обязательны'
    ]);
    exit();
}

// Настройки почты
$to = "kovalev.vova@list.ru";
$subject = "Новая заявка с сайта РПСС от $name";

// Текст письма
$emailMessage = "
НОВАЯ ЗАЯВКА С САЙТА РПСС

Имя: $name
Телефон: $phone
" . ($email ? "Email: $email\n" : "") . "
Тип объекта: " . ($object_type ?: 'Не указан') . "
" . ($message ? "Сообщение:\n$message\n" : "") . "
Дата: " . date('d.m.Y H:i:s') . "
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