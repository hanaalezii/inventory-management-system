<?php
session_start();
include 'panel.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "adiconditioner");
if ($conn->connect_error) {
    die("Lidhja me DB deshtoi: " . $conn->connect_error);
}

// Fshirja e produktit
if (isset($_GET['delete_product'])) {
    $id = intval($_GET['delete_product']);
    if ($conn->query("DELETE FROM products WHERE id = $id")) {
        echo "<script>alert('Produkti u fshi me sukses!'); window.location.href='raportet.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gabim gjatë fshirjes së produktit!'); window.location.href='raportet.php';</script>";
        exit();
    }
}

// Fshirja e porosisë
if (isset($_GET['delete_order'])) {
    $id = intval($_GET['delete_order']);
    if ($conn->query("DELETE FROM orders WHERE id = $id")) {
        echo "<script>alert('Porosia u fshi me sukses!'); window.location.href='raportet.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gabim gjatë fshirjes së porosisë!'); window.location.href='raportet.php';</script>";
        exit();
    }
}

// Fshirja e pagesës
if (isset($_GET['delete_payment'])) {
    $id = intval($_GET['delete_payment']);
    if ($conn->query("DELETE FROM payments WHERE id = $id")) {
        echo "<script>alert('Pagesa u fshi me sukses!'); window.location.href='raportet.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gabim gjatë fshirjes së pagesës!'); window.location.href='raportet.php';</script>";
        exit();
    }
}

// Përditësimi i produktit
if (isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $emri = $conn->real_escape_string($_POST['emri']);
    $pershkrimi = $conn->real_escape_string($_POST['pershkrimi']);
    $kategoria = $conn->real_escape_string($_POST['kategoria']);
    $prodhuesi = $conn->real_escape_string($_POST['prodhuesi']);
    $cmimi = floatval($_POST['cmimi']);
    $sasia = intval($_POST['sasia']);

    if ($conn->query("UPDATE products SET emri='$emri', pershkrimi='$pershkrimi', kategoria='$kategoria', prodhuesi='$prodhuesi', cmimi=$cmimi, sasia=$sasia WHERE id=$id")) {
        echo "<script>alert('Produkti u përditësua me sukses!'); window.location.href='raportet.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gabim gjatë përditësimit të produktit!'); window.location.href='raportet.php';</script>";
        exit();
    }
}


if (isset($_POST['update_order'])) {
    $id = intval($_POST['id']);
    $emri_klientit = $conn->real_escape_string($_POST['emri_klientit']);
    $produkti = $conn->real_escape_string($_POST['produkti']);
    $sasia = intval($_POST['sasia']);
    $status = $conn->real_escape_string($_POST['status']);

    $result = $conn->query("SELECT cmimi FROM products WHERE emri = '$produkti' LIMIT 1");
    $cmimi_per_njesi = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['cmimi'] : 0;
    $cmimi_total = $cmimi_per_njesi * $sasia;

    if ($conn->query("UPDATE orders SET emri_klientit='$emri_klientit', produkti='$produkti', sasia=$sasia, cmimi_total=$cmimi_total, status='$status' WHERE id=$id")) {
        echo "<script>alert('Porosia u përditësua me sukses!'); window.location.href='raportet.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gabim gjatë përditësimit të porosisë!'); window.location.href='raportet.php';</script>";
        exit();
    }
}


$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
$payments = $conn->query("SELECT * FROM payments ORDER BY data_krijimit DESC");
?>


<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Raportet e Produkteve, Porosive dhe Pagesave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        h2 {
            margin-bottom: 10px;
            color: #d4ccff;
        }

        .section-container {
            padding: 15px;
            margin-bottom: 40px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px 12px;
            text-align: center;
            background-color: #b3a1ff;
        }

        .action-buttons button,
        .action-buttons a {
            margin: 5px 5px;
            padding: 5px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            color: white;
        }

        .btn-edit {
            background-color: #6842b3;
        }

        .btn-delete {
            background-color: #c0392b;
            text-decoration: none;
            display: inline-block;
        }

        .btn-save {
            background-color: #27ae60;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .edit-row {
            display: none;
            background-color: #c3b7ff;
        }

        .search-input {
            width: 100%;
            padding: 6px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <script>
        function toggleEdit(id, type) {
            const row = document.getElementById(type + '-edit-' + id);
            row.style.display = (row.style.display === 'table-row') ? 'none' : 'table-row';
        }

        function searchTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                let visible = false;
                const td = tr[i].getElementsByTagName('td');
                for (let j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        visible = true;
                        break;
                    }
                }
                tr[i].style.display = visible ? '' : 'none';
            }
        }
    </script>
</head>

<body>

    <div class="section-container">
        <h2>Raporti i Produkteve</h2>
        <input type="text" class="search-input" id="search-products" onkeyup="searchTable('search-products','products-table')" placeholder="Kërko produkt...">
        <table id="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Përshkrimi</th>
                    <th>Kategoria</th>
                    <th>Prodhuesi</th>
                    <th>Çmimi (€)</th>
                    <th>Sasia</th>
                    <th>Data</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['emri']); ?></td>
                    <td><?= htmlspecialchars($row['pershkrimi']); ?></td>
                    <td><?= htmlspecialchars($row['kategoria']); ?></td>
                    <td><?= htmlspecialchars($row['prodhuesi']); ?></td>
                    <td><?= number_format($row['cmimi'],2); ?> €</td>
                    <td><?= intval($row['sasia']); ?></td>
                    <td><?= $row['data_regjistrimit']; ?></td>
                    <td class="action-buttons">
                        <button class="btn-edit" onclick="toggleEdit(<?= $row['id']; ?>,'product')"><i class="fas fa-edit"></i></button>
                        <a href="raportet.php?delete_product=<?= $row['id']; ?>" onclick="return confirm('A jeni i sigurt?')" class="btn-delete"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <tr class="edit-row" id="product-edit-<?= $row['id']; ?>">
                    <form method="post">
                        <td><?= $row['id']; ?><input type="hidden" name="id" value="<?= $row['id']; ?>"></td>
                        <td><input type="text" name="emri" value="<?= htmlspecialchars($row['emri']); ?>" required></td>
                        <td><input type="text" name="pershkrimi" value="<?= htmlspecialchars($row['pershkrimi']); ?>" required></td>
                        <td>
                            <select name="kategoria" required>
                                <option value="Split" <?= $row['kategoria']=='Split'?'selected':'' ?>>Split</option>
                                <option value="Inverter" <?= $row['kategoria']=='Inverter'?'selected':'' ?>>Inverter</option>
                                <option value="Portable" <?= $row['kategoria']=='Portable'?'selected':'' ?>>Portable</option>
                                <option value="Cassette" <?= $row['kategoria']=='Cassette'?'selected':'' ?>>Cassette</option>
                            </select>
                        </td>
                        <td>
                            <select name="prodhuesi" required>
                                <option value="Midea" <?= $row['prodhuesi']=='Midea'?'selected':'' ?>>Midea</option>
                                <option value="TCL" <?= $row['prodhuesi']=='TCL'?'selected':'' ?>>TCL</option>
                                <option value="Bruno" <?= $row['prodhuesi']=='Bruno'?'selected':'' ?>>Bruno</option>
                                <option value="LG" <?= $row['prodhuesi']=='LG'?'selected':'' ?>>LG</option>
                            </select>
                        </td>
                        <td><input type="number" step="0.01" name="cmimi" value="<?= $row['cmimi']; ?>" required></td>
                        <td><input type="number" name="sasia" value="<?= intval($row['sasia']); ?>" required></td>
                        <td><?= $row['data_regjistrimit']; ?></td>
                        <td><button type="submit" name="update_product" class="btn-save">Ruaj</button></td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="section-container">
        <h2>Raporti i Porosive</h2>
        <input type="text" class="search-input" id="search-orders" onkeyup="searchTable('search-orders','orders-table')" placeholder="Kërko porosi...">
        <table id="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri Klientit</th>
                    <th>Produkti</th>
                    <th>Sasia</th>
                    <th>Çmimi Total (€)</th>
                    <th>Statusi</th>
                    <th>Data</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['emri_klientit']); ?></td>
                    <td><?= htmlspecialchars($row['produkti']); ?></td>
                    <td><?= intval($row['sasia']); ?></td>
                    <td><?= number_format($row['cmimi_total'],2); ?> €</td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= $row['created_at']; ?></td>
                    <td class="action-buttons">
                        <button class="btn-edit" onclick="toggleEdit(<?= $row['id']; ?>,'order')"><i class="fas fa-edit"></i></button>
                        <a href="raportet.php?delete_order=<?= $row['id']; ?>" onclick="return confirm('A jeni i sigurt?')" class="btn-delete"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <tr class="edit-row" id="order-edit-<?= $row['id']; ?>">
                    <form method="post">
                        <td><?= $row['id']; ?><input type="hidden" name="id" value="<?= $row['id']; ?>"></td>
                        <td><input type="text" name="emri_klientit" value="<?= htmlspecialchars($row['emri_klientit']); ?>" required></td>
                        <td><input type="text" name="produkti" value="<?= htmlspecialchars($row['produkti']); ?>" required></td>
                        <td><input type="number" name="sasia" value="<?= intval($row['sasia']); ?>" required></td>
                        <td><input type="number" step="0.01" name="cmimi_total" value="<?= number_format($row['cmimi_total'],2); ?>" readonly></td>
                        <td>
                            <select name="status" required>
                                <option value="E papaguar" <?= $row['status']=='E papaguar'?'selected':'' ?>>E papaguar</option>
                                <option value="E paguar" <?= $row['status']=='E paguar'?'selected':'' ?>>E paguar</option>
                            </select>
                        </td>
                        <td><?= $row['created_at']; ?></td>
                        <td><button type="submit" name="update_order" class="btn-save">Ruaj</button></td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="section-container">
        <h2>Raporti i Pagesave</h2>
        <input type="text" class="search-input" id="search-payments" onkeyup="searchTable('search-payments','payments-table')" placeholder="Kërko pagesa...">
        <table id="payments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri Klientit</th>
                    <th>Produkti</th>
                    <th>Sasia</th>
                    <th>Çmimi pa TVSH (€)</th>
                    <th>TVSH (€)</th>
                    <th>Totali (€)</th>
                    <th>Statusi</th>
                    <th>Data</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$payments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['emri_klientit']); ?></td>
                    <td><?= htmlspecialchars($row['produkti']); ?></td>
                    <td><?= intval($row['sasia']); ?></td>
                    <td><?= number_format($row['cmimi_pa_tvsh'],2); ?></td>
                    <td><?= number_format($row['tvsh'],2); ?></td>
                    <td><?= number_format($row['cmimi_total'],2); ?></td>
                    <td><?= $row['status']; ?></td>
                    <td><?= $row['data_krijimit']; ?></td>
                    <td class="action-buttons">
                        <a href="raportet.php?delete_payment=<?= $row['id']; ?>" onclick="return confirm('A jeni i sigurt?')" class="btn-delete"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>