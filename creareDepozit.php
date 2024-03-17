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

$errorMsg = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["creare_depozit"])) {
    $ID_cont = $_POST["ID_Cont"];
    $Tip_Tranzactie = "Depunere";
    $Suma = $_POST["Suma"];
    $ID_Client = $_SESSION['ID_Client'];
    
    $checkOwnershipStmt = $conn->prepare("SELECT ID_Cont FROM conturi WHERE ID_Cont = ? AND ID_Client = ?");
    $checkOwnershipStmt->bind_param("ii", $ID_cont, $ID_Client);
    $checkOwnershipStmt->execute();
    $checkOwnershipResult = $checkOwnershipStmt->get_result();

    if ($checkOwnershipResult->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO tranzactii (Tip_Tranzactie, Suma, ID_Cont) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $Tip_Tranzactie, $Suma, $ID_cont);

        if ($stmt->execute()) {
            header("Location: tranzactii.php");
            exit();
        } else {
            $errorMsg = "Error: " . $stmt->error . "<br>Debugging: Transaction creation failed.";
        }

        $stmt->close();
    } else {
        $errorMsg = "Nu ai dreptul să faci depozit în acest cont.";
    }

    $checkOwnershipStmt->close();
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
    <title>Creare Transfer</title>
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
        <h2>Depozit</h2>
        <form action="creareDepozit.php" method="post">
            <label for="ID_Cont">ID Cont:</label>
            <input type="number" name="ID_Cont" required><br>

            <label for="suma">Suma:</label>
            <input type="number" name="Suma" required><br>
            <input type="submit" name="creare_depozit" value="Transfer">
        </form>
        <div class="error-message"><?php echo $errorMsg; ?></div>
    </div>

    <div class="info-panel">
        <h3>Beneficii ale depozitelor online:</h3>
        <ul>
            <li>Accesibilitate: Depune bani în contul tău de oriunde, oricând, cu ajutorul internetului.</li>
            <li>Economie de timp: Realizezi depuneri rapid, fără a fi nevoie să te deplasezi fizic la bancă.</li>
            <li>Monitorizare în timp real: Poți verifica suma depusă și tranzacțiile în timp real.</li>
            <li>Securitate sporită: Depunerile online beneficiază de protocoale de securitate avansate.</li>
            <li>Notificări instant: Primești alerte și notificări imediate pentru fiecare depunere efectuată.</li>
            <li>Servicii non-stop: Poți efectua depuneri 24/7, inclusiv în zilele nelucrătoare.</li>
        </ul>
    </div>
</div>
</body>
</html>
