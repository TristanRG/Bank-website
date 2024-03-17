<?php
session_start();

if (!isset($_SESSION['ID_Client'])) {
    header("Location: login.html");
    exit();
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "banca";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["creare_cont"])) {
    $tip_cont = $_POST["tip_cont"];
    $sold = $_POST["sold"];
    $ID_Client = $_SESSION['ID_Client'];

    $stmt = $conn->prepare("INSERT INTO conturi (Tip_Cont, Sold, Stare, ID_Client) VALUES (?, ?, 'Activ', ?)");
    $stmt->bind_param("sdi", $tip_cont, $sold, $ID_Client);

    if ($stmt->execute()) {
        header("Location: cont.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        echo "Debugging: Cont creation failed.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="meniu.css">
    <link rel="stylesheet" href="creareCont.css">
    <title>Creare Cont</title>
</head>
<body>

<div class="upper-menu">
    <div class="menu-items">
        <a href="main.php">Banca</a>
        <span class="menu-separator"></span>
        <a href="cont.php">Cont</a>
        <span class="menu-separator"></span>
        <a href="rate.php">Rate</a>
        <span class="menu-separator"></span>
        <a href="tranzactii.php">Tranzactii</a>
    </div>
    <div class="login-register">
        <?php

        if (isset($_SESSION['ID_Client'])) {
            echo '<span class="user-name">' . $_SESSION['Nume'] . ' ' . $_SESSION['Prenume'] . '</span>';
            echo '<span class="menu-separator"></span>';
            echo '<a href="logout.php" class="logout">Logout</a>';
        } else {
            echo '<a href="login.html" class="login">Log in</a>';
            echo '<span class="menu-separator"></span>';
            echo '<a href="register.html" class="register">Register</a>';
        }
        ?>
    </div>
</div>

<div class="content-container">
    <div class="form-container">
        <h2>Creare Cont</h2>
        <form action="creareCont.php" method="post">
            <label for="tip_cont">Tip Cont:</label>
    <select name="tip_cont" required>
        <option value="Economic">Economic</option>
        <option value="Debit">Debit</option>
        <option value="Credit">Credit</option>
        <option value="Commercial">Commercial</option>
    </select><br>

    <label for="sold">Sold:</label>
    <input type="number" name="sold" required><br>

    <input type="submit" name="creare_cont" value="Creare Cont">
</form>
</div>

<div class="info-panel">
    <h3>Beneficii ale conturilor online:</h3>
    <ul>
        <li>Accesibilitate: Poți gestiona contul tău de oriunde, oricând, cu ajutorul internetului.</li>
        <li>Economie de timp: Realizezi tranzacții și plăți rapid, fără a fi nevoie să te deplasezi fizic la bancă.</li>
        <li>Monitorizare în timp real: Poți verifica soldul și tranzacțiile în timp real.</li>
        <li>Securitate sporită: Serviciile online beneficiază de protocoale de securitate avansate.</li>
        <li>Notificări instant: Primești alerte și notificări imediate pentru activități importante.</li>
        <li>Servicii non-stop: Poți accesa contul și efectua operațiuni 24/7, inclusiv în zilele nelucrătoare.</li>
    </ul>
    </div>
</div>
</body>
</html>
