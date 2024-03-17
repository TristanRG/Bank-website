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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["creare_rata"])) {
    $ID_Cont = $_POST["ID_Cont"];
    $suma_rata = $_POST["suma_rata"];
    $tip_rata = $_POST["tip_rata"];
    $termen = $_POST["termen"];
    $ID_Client = $_SESSION['ID_Client'];

    $checkOwnershipStmt = $conn->prepare("SELECT ID_Cont FROM conturi WHERE ID_Cont = ? AND ID_Client = ?");
    $checkOwnershipStmt->bind_param("ii", $ID_Cont, $ID_Client);
    $checkOwnershipStmt->execute();
    $checkOwnershipResult = $checkOwnershipStmt->get_result();

    if ($checkOwnershipResult->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO rate (ID_Cont, Suma_Rata, Data_Inceput, Tip_Rata, Termen, Stare_Rata) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?, 'Activ')");
        $stmt->bind_param("idsi", $ID_Cont, $suma_rata, $tip_rata, $termen);

        if ($stmt->execute()) {
            header("Location: rate.php");
            exit();
        } else {
            $errorMsg = "Error: " . $stmt->error . "<br>Debugging: Rata creation failed.";
        }

        $stmt->close();
    } else {
        $errorMsg = "Nu ai dreptul sa creezi rate pentru acest cont.";
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
    <title>Creare Rata</title>
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
        <h2>Creare Rata</h2>
        <form action="creareRata.php" method="post">
            <label for="ID_Cont">ID Cont:</label>
            <input type="number" name="ID_Cont" required><br>

            <label for="suma_rata">Suma Rata:</label>
            <input type="number" name="suma_rata" required><br>

            <label for="tip_rata">Tip Rata:</label>
            <select name="tip_rata" required>
                <option value="Auto">Auto</option>
                <option value="Debit">Business</option>
                <option value="Credit">Personala</option>
                <option value="Commercial">Ipotecara</option>
            </select><br>

            <label for="termen">Termen (in luni):</label>
            <input type="number" name="termen" required><br>

            <input type="submit" name="creare_rata" value="Creare Rata">
        </form>
        <div class="error-message"><?php echo $errorMsg; ?></div>
    </div>
</div>
</body>
</html>
