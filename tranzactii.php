<?php
session_start(); 

if (!isset($_SESSION['ID_Client'])) {
    header("Location: login.html");
    exit();
}

$ID_Client = $_SESSION['ID_Client'];

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "banca";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM tranzactii WHERE ID_Cont IN (SELECT ID_Cont FROM conturi WHERE ID_Client = ?)");
$stmt->bind_param("i", $ID_Client);
$stmt->execute();
$result = $stmt->get_result();
$tranzactii = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tranzactii</title>
    <link rel="stylesheet" href="meniu.css">
    <link rel="stylesheet" href="tranzactii.css">
    <script src="salvare.js"></script>
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

<h2>Detalii Tranzactii</h2>

<table>
    <thead>
        <tr>
            <th>ID Tranzactie</th>
            <th>ID Cont</th>
            <th>ID Cont Destinatie</th>
            <th>Suma</th>
            <th>Tip Tranzactie</th>
            <th>Data Tranzactiei</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tranzactii as $tranzactie): ?>
            <tr>
                <td><?php echo $tranzactie['ID_Tranzactie']; ?></td>
                <td><?php echo $tranzactie['ID_Cont']; ?></td>
                <td><?php echo $tranzactie['ID_Cont_Destinatie']; ?></td>
                <td><?php echo $tranzactie['Suma']; ?></td>
                <td><?php echo $tranzactie['Tip_Tranzactie']; ?></td>
                <td><?php echo $tranzactie['Data_tranzactiei']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="container">
    <p>Explorează beneficiile economisirii și depune bani în contul tău acum!</p>
    <a href="creareDepozit.php">Depune Bani</a>
</div>

<div class="container-2">
    <p>Descoperă experiența plăților rapide și ușoare! Trimite bani către oricine, oriunde!</p>
    <a href="creareTransfer.php">Trimite Bani</a>
</div>
</body>
</html>
