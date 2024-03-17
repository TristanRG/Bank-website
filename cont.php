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

$stmt = $conn->prepare("SELECT * FROM conturi WHERE ID_Client = ?");
$stmt->bind_param("i", $ID_Client);
$stmt->execute();
$result = $stmt->get_result();
$accounts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cont</title>
    <link rel="stylesheet" href="meniu.css">
    <link rel="stylesheet" href="cont.css">
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

<h2>Detalii Conturi</h2>

<table>
    <thead>
        <tr>
            <th>ID Cont</th>
            <th>ID Client</th>
            <th>Sold</th>
            <th>Tip Cont</th>
            <th>Data Creare Cont</th>
            <th>Stare</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accounts as $account): ?>
            <tr>
                <td><?php echo $account['ID_Cont']; ?></td>
                <td><?php echo $account['ID_Client']; ?></td>
                <td><?php echo $account['Sold']; ?></td>
                <td><?php echo $account['Tip_Cont']; ?></td>
                <td><?php echo $account['Data_Creare_Cont']; ?></td>
                <td><?php echo $account['Stare']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="box box1">
    <h1><a href="creareCont.php">Deschide-ti un cont nou 100% online</a></h1>
</div>

<div class="box box2">
    <h2><a href="creareDepozit.php">Adauga bani intr-un cont existent</a></h2>
</div>

</body>
</html>
