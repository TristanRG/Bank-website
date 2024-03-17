<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="meniu.css">
    <link rel="stylesheet" href="styles.css">
    <title>Main Page</title>
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
            session_start(); 
    
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
    

<div class="upper-half">
    <div class="slideshow-container" id="slideshow-container"></div>
</div>

<div class="lower-half">
    <div class="box box1">
        <h3>Te gândești să-ți deschizi un cont online?</h3>
        <div class="bonuses">
            <p>Acces la servicii bancare online 24/7</p>
            <p>Zero comisioane la tranzacțiile online</p>
            <p>Oferte exclusive pentru posesorii de carduri online</p>
        </div>
    </div>
    <div class="box box2">
        <h3>Ai nevoie de o rată stabilă?</h3>
        <div class="bonuses">
            <p>Rată fixă pentru toate tipurile de împrumuturi</p>
            <p>Flexibilitate în alegerea perioadei de rambursare</p>
            <p>Dobândă fixă de 10% pentru împrumuturile online</p>
        </div>
    </div>
    <div class="box box3">
        <h3>Descoperă avantajele tranzacțiilor online!</h3>
        <div class="bonuses">
            <p>Plăți rapide și ușoare</p>
            <p>Securitate sporită a tranzacțiilor</p>
            <p>Bonusuri și cashback la utilizarea cardului online</p>
        </div>
    </div>
</div>

<script src="slideshow.js"></script>

</body>
</html>
