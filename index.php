<?php
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$conn = new mysqli('localhost', 'root', '', 'adiconditioner');
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST['emri'];
    $pershkrimi = $_POST['pershkrimi'];
    $kategoria = $_POST['kategoria'];
    $cmimi = $_POST['cmimi'];
    $sasia = $_POST['sasia'];
    $prodhuesi = $_POST['prodhuesi'];
    $data_regjistrimit = date('Y-m-d');


    $stmt = $conn->prepare("INSERT INTO products (emri, pershkrimi, kategoria, prodhuesi, cmimi, sasia, data_regjistrimit) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssdis", $emri, $pershkrimi, $kategoria, $prodhuesi, $cmimi, $sasia, $data_regjistrimit);


    if ($stmt->execute()) {
        echo "<script>alert('Produkti u regjistrua me sukses!'); window.location.href = 'raportet.php'; </script>";
    } else {
        echo "<script>alert('Gabim gjatë regjistrimit: " . $conn->error . "');</script>";
         
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADI Conditioner - Paneli Admin</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="style-dashboard.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <?php include 'panel.php'; ?>

    <div class="dashboard-container2">
        <div class="welcome-section">
            <h1>Mirë se vini në Panelin e Administratorit</h1>
            <p>Ky është paneli juaj i kontrollit ku mund të menaxhoni porositë, përdoruesit, pagesat dhe produktet.</p>
        </div>
        <div class="form-section">
            <h2>Regjistro një produkt të ri</h2>
            <form method="POST" action="" class="product-form">
                <label for="emri">Emri i produktit:</label>
                <input type="text" id="emri" name="emri" required>

                <label for="pershkrimi">Përshkrimi:</label>
                <textarea id="pershkrimi" name="pershkrimi" required></textarea>

                <label for="kategoria" class="label-stil">Kategoria:</label>
                <select id="kategoria" name="kategoria" required>
                    <option value="" disabled selected>Zgjedh Kategorinë</option>
                    <option value="Split">Split</option>
                    <option value="Inverter">Inverter</option>
                    <option value="Portable">Portable</option>
                    <option value="Cassette">Cassette</option>
                </select>

                <label for="cmimi">Çmimi (€):</label>
                <input type="number" step="0.01" id="cmimi" name="cmimi" required>

                <label for="sasia">Sasia në stok:</label>
                <input type="number" id="sasia" name="sasia" required>

                <label for="prodhuesi" class="label-stil">Prodhuesi:</label>
                <select name="prodhuesi" id="prodhuesi" required>
                    <option value="" disabled selected>Zgjedh prodhuesin</option>
                    <option value="Midea">Midea</option>
                    <option value="TCL">TCL</option>
                    <option value="Bruno">Bruno</option>
                    <option value="LG">LG</option>
                </select>



                <button type="submit">Regjistro Produktin</button>
            </form>
        </div>


    </div>
    </div>







</body>

</html>