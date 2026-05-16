<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = trim($_POST['emri']);
    $email = trim($_POST['email']);
    $fjalekalimi = $_POST['fjalekalimi'];
    $cpassword = $_POST['cpassword'];

    $error = '';


    if (empty($emri) || !preg_match("/^[a-zA-Z\s]+$/", $emri)) {
        $error = "Emri duhet të jetë vetëm me shkronja dhe jo bosh.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email-i nuk është valid.";
    } elseif (strlen($fjalekalimi) < 6) {
        $error = "Fjalëkalimi duhet të ketë të paktën 6 karaktere.";
    } elseif ($fjalekalimi !== $cpassword) {
        $error = "Fjalëkalimet nuk përputhen!";
    }

    if (!$error) {
     
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Ky email është përdorur!";
        } else {
         
            $hashed = password_hash($fjalekalimi, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (emri, email, fjalekalimi) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $emri, $email, $hashed);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Regjistrimi u krye me sukses! Tani mund të kyçesh.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Gabim gjatë regjistrimit: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Regjistrohu - ADI Conditioner</title>
    <link rel="stylesheet" href="style_login.css" />
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h2>Regjistrohu</h2>

            <?php if (!empty($error)): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <input type="text" name="emri" placeholder="Emri" value="<?= isset($emri) ? htmlspecialchars($emri) : '' ?>" required />
            <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required />
            <input type="password" name="fjalekalimi" placeholder="Fjalëkalimi" required />
            <input type="password" name="cpassword" placeholder="Konfirmo Fjalëkalimin" required />
            <button type="submit">Regjistrohu</button>
            <p>Ke llogari? <a href="login.php">Kyçu këtu</a></p>
        </form>
    </div>
</body>
</html>
