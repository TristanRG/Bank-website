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

$stmt = $conn->prepare("SELECT * FROM rate WHERE ID_Cont IN (SELECT ID_Cont FROM conturi WHERE ID_Client = ?)");
$stmt->bind_param("i", $ID_Client);
$stmt->execute();
$result = $stmt->get_result();
$rate = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate</title>
    <link rel="stylesheet" href="meniu.css">
    <link rel="stylesheet" href="rate.css">
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

<h2>Detalii Rate</h2>

<table>
    <thead>
        <tr>
            <th>ID Rata</th>
            <th>ID Cont</th>
            <th>Suma Rata</th>
            <th>Stare Rata</th>
            <th>Tip Rata</th>
            <th>Data Inceput</th>
            <th>Data Scadenta</th>
            <th>Termen</th>
            <th>Rata Lunara</th>
            <th>Dobanda Lunara</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($rate as $rate): ?>
            <tr>
                <td><?php echo $rate['ID_Rata']; ?></td>
                <td><?php echo $rate['ID_Cont']; ?></td>
                <td><?php echo $rate['Suma_Rata']; ?></td>
                <td><?php echo $rate['Stare_Rata']; ?></td>
                <td><?php echo $rate['Tip_Rata']; ?></td>
                <td><?php echo $rate['Data_Inceput']; ?></td>
                <td><?php echo $rate['Data_Scadenta']; ?></td>
                <td><?php echo $rate['Termen']; ?></td>
                <td><?php echo $rate['Rata_Lunara']; ?></td>
                <td><?php echo $rate['Dobanda_Lunara']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="container">
    <p>Dorești o rată cu dobândă fixă?</p>
    <a href="creareRata.php">Crează-ți o rată personalizată</a>
</div>
</body>
</html>