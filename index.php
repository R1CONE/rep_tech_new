<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost"; // Nazwa serwera bazy danych
$username = "root"; // Nazwa użytkownika bazy danych
$password = ""; // Hasło użytkownika bazy danych
$database = "try_bd"; // Nazwa bazy danych

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $database);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
} else {

    // Sprawdzamy, czy formularz został wysłany
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pobieramy dane z formularza
        $login = $_POST["login"];
        $haslo = $_POST["password"];

        // Sprawdzamy unikalność loginu
        $query_sprawdz = "SELECT * FROM accounts WHERE login = '$login'";
        $result = $conn->query($query_sprawdz);

        if ($result->num_rows > 0) {
            echo "Błąd: login '$login' już istnieje. Proszę wybrać inny login.";
        } else {
            // Używamy zapytania przygotowanego, aby zapobiec atakom SQL injection
            $stmt = $conn->prepare("INSERT INTO accounts (login, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $haslo);

            if ($stmt->execute()) {
                header("Location: main.html");
                exit();
            } else {
                echo "Błąd: " . $stmt->error;
            }

            $stmt->close();
        }

        $result->close();
    }

    // Zamykamy połączenie
    $conn->close();
}
?>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="login">Login:</label>
    <input type="text" name="login" required>

    <label for="password">Hasło:</label>
    <input type="password" name="password" required>

    <input type="submit" value="Zarejestruj się">
</form>

</body>
</html>
