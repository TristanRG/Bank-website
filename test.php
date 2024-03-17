<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "banca";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function hashPassword($rawPassword) {
    return password_hash($rawPassword, PASSWORD_DEFAULT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $nume = $_POST["nume"];
    $prenume = $_POST["prenume"];
    $parola = hashPassword($_POST["parola"]);
    $cnp = $_POST["cnp"];
    $adresa = $_POST["adresa"];
    $numar_telefon = $_POST["numar_telefon"];
    $email = $_POST["email"];

    $checkEmailStmt = $conn->prepare("SELECT ID_Client FROM clienti WHERE Email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();

    if ($checkEmailResult->num_rows > 0) {
        $checkEmailStmt->close();
        echo "Acest email este deja folosit!";
    } else {
        $checkEmailStmt->close();

        $insertStmt = $conn->prepare("INSERT INTO clienti (Nume, Prenume, Parola, CNP, Adresa, Numar_Telefon, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssssss", $nume, $prenume, $parola, $cnp, $adresa, $numar_telefon, $email);

        if ($insertStmt->execute()) {
            $_SESSION['ID_Client'] = $insertStmt->insert_id;
            $_SESSION['Nume'] = $nume;
            $_SESSION['Prenume'] = $prenume;

            $insertStmt->close();

            header("Location: main.php");
            exit();
        } else {
            echo "Error: " . $insertStmt->error;
            echo "Debugging: Registration failed.";
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["parola"];

    $stmt = $conn->prepare("SELECT ID_Client, Nume, Prenume, Parola FROM clienti WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["Parola"];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['ID_Client'] = $row['ID_Client'];
            $_SESSION['Nume'] = $row['Nume'];
            $_SESSION['Prenume'] = $row['Prenume'];

            header("Location: main.php");
            exit(); 
        } else {
            $_SESSION['loginError'] = "Parola incorecta.";
            header("Location: login.html");
            exit();
        }
    } else {
        $_SESSION['loginError'] = "Emailul nu exista.";
        header("Location: login.html");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>