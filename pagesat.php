<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['pagua_id'])) {
    $id = intval($_GET['pagua_id']);

 
    $stmt1 = $conn->prepare("SELECT emri_klientit, produkti, sasia, cmimi_total FROM orders WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row = $result1->fetch_assoc();

  
    $tvsh_perqindje = 18;
    $cmimi_total = $row['cmimi_total'];
    $cmimi_pa_tvsh = $cmimi_total / (1 + $tvsh_perqindje / 100);
    $tvsh = $cmimi_total - $cmimi_pa_tvsh;


    $stmt2 = $conn->prepare("INSERT INTO payments 
        (emri_klientit, produkti, sasia, cmimi_pa_tvsh, tvsh, cmimi_total, status)
        VALUES (?, ?, ?, ?, ?, ?, 'E paguar')");
    $stmt2->bind_param("ssiddd", 
        $row['emri_klientit'], 
        $row['produkti'], 
        $row['sasia'], 
        $cmimi_pa_tvsh, 
        $tvsh, 
        $cmimi_total
    );
    $stmt2->execute();


    $stmt3 = $conn->prepare("UPDATE orders SET status = 'E paguar' WHERE id = ?");
    $stmt3->bind_param("i", $id);
    $stmt3->execute();

   
    header("Location: pagesat.php?success=1");
    exit();
}

include 'panel.php';


$sql = "SELECT * FROM orders WHERE status != 'E paguar' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <title>Menaxho Pagesat</title>
    <link rel="stylesheet" href="style-pagesat.css" />
</head>

<body>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        alert("Porosia u shënua si e paguar me sukses!");
    </script>
    <?php endif; ?>

    <div class="pagesat-container">
        <h2 class="pagesat-title">Lista e Porosive për Pagesë</h2>
        <table class="pagesat-table">
            <thead>
                <tr>
                    <th class="pagesat-th">ID</th>
                    <th class="pagesat-th">Emri i Klientit</th>
                    <th class="pagesat-th">Produkti</th>
                    <th class="pagesat-th">Sasia</th>
                    <th class="pagesat-th">Çmimi pa TVSH (€)</th>
                    <th class="pagesat-th">TVSH (18%) (€)</th>
                    <th class="pagesat-th">Totali (€)</th>
                    <th class="pagesat-th">Statusi</th>
                    <th class="pagesat-th">Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <?php
                        $tvsh_perqindje = 18;
                        $cmimi_total = $row['cmimi_total'];
                        $cmimi_pa_tvsh = $cmimi_total / (1 + $tvsh_perqindje / 100);
                        $tvsh_shuma = $cmimi_total - $cmimi_pa_tvsh;
                    ?>
                <tr class="pagesat-tr">
                    <td class="pagesat-td"><?= $row['id'] ?></td>
                    <td class="pagesat-td"><?= htmlspecialchars($row['emri_klientit']) ?></td>
                    <td class="pagesat-td"><?= htmlspecialchars($row['produkti']) ?></td>
                    <td class="pagesat-td"><?= $row['sasia'] ?></td>
                    <td class="pagesat-td"><?= number_format($cmimi_pa_tvsh, 2)  . " €"  ?></td>
                    <td class="pagesat-td"><?= number_format($tvsh_shuma, 2) . " €"  ?></td>
                    <td class="pagesat-td"><strong><?= number_format($cmimi_total, 2) . " €"  ?></strong></td>
                    <td class="pagesat-td"><?= $row['status'] ?></td>
                    <td class="pagesat-td">
                        <a href="pagesat.php?pagua_id=<?= $row['id'] ?>" class="pagesat-btn-paguaj" onclick="return confirm('Jeni i sigurt që dëshironi të shënoni këtë porosi si të paguar?');">
                            Paguaj
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr class="pagesat-tr">
                    <td class="pagesat-td" colspan="9" style="text-align:center;">
                        Nuk ka porosi për pagesë.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>