<?php

// Стандартные данные для письма
$mailTo = "example@gmail";
$mailFrom = "User";
$mailSubject = "Test Attachment";
$mailMessage = "<strong>Test Message</strong>";
$mailAttach = [];
$filesize = 0;

// Заполнение данных из формы
$files = $_FILES;
$spamControl = $_POST["spamControl"];
$mailFrom = $_POST["name"];
$mailTo = $_POST["mail"];

// Сбор всех прикреплённых файлов
foreach ($files as $file) {
    array_push($mailAttach, $file["tmp_name"]);
    $filesize += $file['size'];
    $fileName = $file["name"];
    // Перенос копий файлов в папку Uploads (автоматическое создание папки)
    if (!is_dir('uploads'))
        mkdir('uploads', 0777, true);
    move_uploaded_file($file["tmp_name"], "uploads/" . $fileName);
    sleep(1);
}


// Создание рандомных границ формы
$mailBoundary = md5(time());
$mailHead = implode("\r\n", [
    "MIME-Version: 1.0",
    "From: " . $mailFrom,
    "Content-Type: multipart/mixed; boundary=\"$mailBoundary\""
]);

// Заполнение тела письма
$mailBody = implode("\r\n", [
    "--$mailBoundary",
    "Content-type: text/html; charset=utf-8",
    "",
    $mailMessage
]);

// Прикрепление всех файлов к телу письма
foreach ($mailAttach as $attach) {
    $mailBody .= implode("\r\n", [
        "",
        "--$mailBoundary",
        "Content-Type: application/octet-stream; name=\"" . basename($attach) . "\"",
        "Content-Transfer-Encoding: base64",
        "Content-Disposition: attachment",
        "",
        chunk_split(base64_encode(file_get_contents($attach))),
        "--$mailBoundary"
    ]);
}
$mailBody .= "--";

// Проверка на максимально допустимый размер файла в 10МБ
if ($filesize < 10000000) {
    // Проверка на СПАМ
    if ($spamControl != "secret") {
        return false;
    }
    mail($mailTo, $mailSubject, $mailBody, $mailHead);
    echo json_encode(["status" => true]);
} else {
    echo 'Письмо не отправлено. Размер всех файлов превышает 10 МБ.';
}
