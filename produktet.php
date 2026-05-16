<?php
session_start(); 

$user = $_SESSION['user'];

$conn = new mysqli('localhost', 'root', '', 'adiconditioner');
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
} 

include 'panel.php';


$whereClauses = [];
if (!empty($_GET['kategoria'])) {
    $whereClauses[] = "kategoria = '" . $conn->real_escape_string($_GET['kategoria']) . "'";
}
if (!empty($_GET['prodhuesi'])) {
    $whereClauses[] = "prodhuesi = '" . $conn->real_escape_string($_GET['prodhuesi']) . "'";
}
$whereSQL = count($whereClauses) > 0 ? "WHERE " . implode(" AND ", $whereClauses) : "";


$produktePerFaqe = 6;
$faqja = isset($_GET['faqja']) ? intval($_GET['faqja']) : 1;
$offset = ($faqja - 1) * $produktePerFaqe;


$sqlCount = "SELECT COUNT(*) as total FROM products $whereSQL";
$resultCount = $conn->query($sqlCount);
$totalProdukte = $resultCount->fetch_assoc()['total'];
$totalFaqe = ceil($totalProdukte / $produktePerFaqe);


$sql = "SELECT * FROM products $whereSQL ORDER BY data_regjistrimit DESC LIMIT $offset, $produktePerFaqe";
$result = $conn->query($sql);
$products = [];
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <title>Produktet</title>
    <link rel="stylesheet" href="style-produktet.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        .produkt-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .produkt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 900px) {
            .produkt-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .produkt-grid {
                grid-template-columns: 1fr;
            }
        }

        .produkt-kart {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #d4ccff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 15px;
            transition: transform 0.3s;
        }

        .produkt-kart:hover {
            transform: translateY(-10px);
        }

        .produkt-info h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }

        .cmimi-produktit {
            font-weight: bold;
            color: greenyellow !important;
            font-size: 18px;
            margin-bottom: 10px;
            background-color: #6842b3;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .produkt-info p {
            flex-grow: 1;
            color: #555;
            font-size: 14px;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-form select,
        .filter-form button {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .filter-form button:hover {
            background-color: #218838;
        }

        .pagination a {
            padding: 6px 10px;
            margin: 2px;
            background: #6842b3;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="produkt-container">


        <form method="GET" class="filter-form">
            <select name="kategoria">
                <option value="">Të gjitha kategoritë</option>
                <option value="Split" <?= (isset($_GET['kategoria']) && $_GET['kategoria']=='Split')?'selected':'' ?>>Split</option>
                <option value="Inverter" <?= (isset($_GET['kategoria']) && $_GET['kategoria']=='Inverter')?'selected':'' ?>>Inverter</option>
                <option value="Portable" <?= (isset($_GET['kategoria']) && $_GET['kategoria']=='Portable')?'selected':'' ?>>Portable</option>
                <option value="Cassette" <?= (isset($_GET['kategoria']) && $_GET['kategoria']=='Cassette')?'selected':'' ?>>Cassette</option>
            </select>

            <select name="prodhuesi">
                <option value="">Të gjithë prodhuesit</option>
                <option value="Midea" <?= (isset($_GET['prodhuesi']) && $_GET['prodhuesi']=='Midea')?'selected':'' ?>>Midea</option>
                <option value="TCL" <?= (isset($_GET['prodhuesi']) && $_GET['prodhuesi']=='TCL')?'selected':'' ?>>TCL</option>
                <option value="Bruno" <?= (isset($_GET['prodhuesi']) && $_GET['prodhuesi']=='Bruno')?'selected':'' ?>>Bruno</option>
                <option value="LG" <?= (isset($_GET['prodhuesi']) && $_GET['prodhuesi']=='LG')?'selected':'' ?>>LG</option>
            </select>

            <button type="submit">Filtro</button>
            <?php if(!empty($_GET['kategoria']) || !empty($_GET['prodhuesi'])): ?>
            <a href="produktet.php" style="padding:6px 10px; background:#6c757d; color:white; border-radius:6px; text-decoration:none;">Hiqe Filtrin</a>
            <?php endif; ?>
        </form>

        <div class="produkt-grid">
            <?php foreach($products as $produkt): ?>
            <div class="produkt-kart">
                <div class="produkt-info">
                    <h3><?= htmlspecialchars($produkt['emri']) ?></h3>
                    <p class="cmimi-produktit"><?= number_format($produkt['cmimi'],2) ?>€</p>
                    <p><?= htmlspecialchars($produkt['pershkrimi']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(count($products) == 0): ?>
            <p>Nuk ka produkte për t'u shfaqur.</p>
            <?php endif; ?>
        </div>


        <?php if($totalFaqe > 1): ?>
        <div class="pagination" style="margin-top:20px; text-align:center;">
            <?php for($i=1; $i<=$totalFaqe; $i++): ?>
            <a href="?faqja=<?= $i ?>&kategoria=<?= $_GET['kategoria'] ?? '' ?>&prodhuesi=<?= $_GET['prodhuesi'] ?? '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

    </div>

</body>

</html>