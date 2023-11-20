<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        #loginForm {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f7f7f7;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #hashResult {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Logowanie</h1>
    <form id="loginForm" method="post">

        <label for="username">Name:</label>
        <input type="text" id="username" name="username" value="">

        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" value="">

        <label for="login">login:</label>
        <input type="text" id="login" name="login" value="">

        <label for="email">email:</label>
        <input type="text" id="email" name="email" value="">

        <label for="password">password:</label>
        <input type="password" id="password" name="password" value="">

        <label for="telephone_number">telephone number:</label>
        <input type="text" id="telephone_number" name="telephone_number" value="">
        
        <input type="submit" value="Zaloguj się" id="button-link">
        
    </form>
    
    <div id="hashResult"></div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userLogin = $_POST["login"];
    $userPassword = $_POST["password"];
    $userName = $_POST["username"];
    $userSurname = $_POST["surname"];
    $userTelephoneNumber = $_POST["telephone_number"];
    $userEmail = $_POST["email"];

    if (!empty($userLogin) && !empty($userPassword)) {
        $servername = "localhost";
        $username = "root";
        $dbPassword = ""; // замените на пароль базы данных
        $database = "try_bd";

        // Создайте подключение к базе данных
        $conn = new mysqli($servername, $username, $dbPassword, $database);

        // Проверка подключения
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        } else {
            // Подготовленный запрос для вставки данных
            $sql = "INSERT INTO accounts (login, password, name, surname, telefnum, email) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Привязываем параметры
            $stmt->bind_param("ssssss", $userLogin, $userPassword, $userName, $userSurname, $userTelephoneNumber, $userEmail);
            
            // Выполняем запрос
            $stmt->execute();
            
            echo "Успешно зарегистрировано!";
            
            // Закрываем подготовленное выражение и соединение
            $stmt->close();
            $conn->close();
        }
    }
}
?>

</body>
</html>