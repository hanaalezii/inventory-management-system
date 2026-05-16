<?php
session_start();
include 'panel.php';
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$showSuccessAlert = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $emri_klientit = $_POST['emri_klientit'] ?? '';
    $produkti = $_POST['produkti'] ?? '';
    $sasia = intval($_POST['sasia'] ?? 1);
    $cmimi_total = floatval($_POST['cmimi_total'] ?? 0);
    $status = $_POST['status'] ?? 'E papaguar';


    if (!empty($emri_klientit) && !empty($produkti) && $sasia > 0 && $cmimi_total > 0) {
        $stmt = $conn->prepare("INSERT INTO orders (emri_klientit, produkti, sasia, cmimi_total, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssids", $emri_klientit, $produkti, $sasia, $cmimi_total, $status);

        if ($stmt->execute()) {
        
            $showSuccessAlert = true;
        } else {
            die("Gabim gjatë regjistrimit të porosisë: " . $stmt->error);
        }
    } else {
        die("Të dhënat e dërguara janë jo valide.");
    }
}

$products = [];
$sql = "SELECT id, emri, cmimi FROM products";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}


?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <title>Shto Porosi</title>
    <link rel="stylesheet" href="style-porosite.css" />
</head>

<body>

    <div class="porosi-container porosi-container-large">
        <h2>Shto Porosi të Re</h2>
        <form action="" method="POST" class="porosi-form" id="porosiForm">
            <div class="porosi-form-group">
                <label class="porosi-label" for="emriKlientit">Emri i Klientit:</label>
                <input type="text" id="emriKlientit" name="emri_klientit" class="porosi-input" required />
            </div>

            <div class="porosi-form-group">
                <label class="porosi-label" for="produktiSelect">Produkti:</label>
                <select name="produkti" id="produktiSelect" class="porosi-select" required>
                    <option value="">-- Zgjedh produktin --</option>
                    <?php foreach ($products as $produkt): ?>
                    <option value="<?= htmlspecialchars($produkt['emri']) ?>" data-cmimi="<?= $produkt['cmimi'] ?>">
                        <?= htmlspecialchars($produkt['emri']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="porosi-form-group">
                <label class="porosi-label" for="sasiaInput">Sasia:</label>
                <input type="number" id="sasiaInput" name="sasia" class="porosi-input" value="1" min="1" required />
            </div>

            <div class="porosi-form-group">
                <label class="porosi-label" for="cmimiTotal">Çmimi Total (€):</label>
                <input type="number" step="0.01" id="cmimiTotal" name="cmimi_total" class="porosi-input" readonly />
            </div>

            <div class="porosi-form-group">
                <label class="porosi-label" for="statusSelect">Statusi:</label>
                <select name="status" id="statusSelect" class="porosi-select" required>
                    <option value="E papaguar">E papaguar</option>

                    <option value="E paguar">E paguar</option>
                </select>
            </div>

            <button type="submit" class="porosi-submit-btn">Regjistro Porosinë</button>
        </form>
    </div>



    <?php if ($showSuccessAlert): ?>
    <script>
        alert("Porosia u regjistrua me sukses!");
    </script>
    <?php endif; ?>

    <script>
        const produktiSelect = document.getElementById('produktiSelect');
        const sasiaInput = document.getElementById('sasiaInput');
        const cmimiTotalInput = document.getElementById('cmimiTotal');

        function updateCmimiTotal() {
            const selectedOption = produktiSelect.options[produktiSelect.selectedIndex];
            const cmimi = parseFloat(selectedOption.getAttribute('data-cmimi')) || 0;
            const sasia = parseInt(sasiaInput.value) || 1;
            const total = (cmimi * sasia).toFixed(2);
            cmimiTotalInput.value = total;
        }

        produktiSelect.addEventListener('change', updateCmimiTotal);
        sasiaInput.addEventListener('input', updateCmimiTotal);


        updateCmimiTotal();
    </script>

</body>

</html>