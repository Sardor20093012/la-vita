<?php
$host = "localhost";
$db = "registration_db";
$user = "root";
$pass = "";

// Подключение к базе данных
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Обработка фото
$photo_name = $_FILES['photo']['name'];
$photo_tmp = $_FILES['photo']['tmp_name'];
$photo_path = "uploads/" . time() . "_" . basename($photo_name);

if (move_uploaded_file($photo_tmp, $photo_path)) {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $photo_path);
    $stmt->execute();
    echo "Регистрация прошла успешно!";
} else {
    echo "Ошибка при загрузке фото.";
}

$conn->close();
?>
