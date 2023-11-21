<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #registrationForm {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007BFF;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
            color: #333;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="registrationForm">
        <h1>Registration</h1>
        <form method="post">

            <label for="username">Name:</label>
            <input type="text" id="username" name="username" placeholder="Enter your name">

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" placeholder="Enter your surname">

            <label for="login">Login:</label>
            <input type="text" id="login" name="login" placeholder="Choose a login">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter your email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password">

            <label for="telephone_number">Phone Number:</label>
            <input type="text" id="telephone_number" name="telephone_number" placeholder="Enter phone number">

            <input type="submit" value="Register">
            
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
        $dbPassword = ""; // replace with your database password
        $database = "try_bd";

        // Create a database connection
        $conn = new mysqli($servername, $username, $dbPassword, $database);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection error: " . $conn->connect_error);
        } else {
            // Prepared statement for inserting data
            $sql = "INSERT INTO accounts (login, password, name, surname, telefnum, email) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bind_param("ssssss", $userLogin, $userPassword, $userName, $userSurname, $userTelephoneNumber, $userEmail);
            
            // Execute the query
            $stmt->execute();
            
            echo "Successfully registered!";
            
            // Close the prepared statement and connection
            $stmt->close();
            $conn->close();
        }
    }
}
?>

</body>
</html>
