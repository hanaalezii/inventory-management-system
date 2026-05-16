
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $fjalekalimi = $_POST['fjalekalimi'];

    $error = '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email-i nuk është valid.";
    } elseif (strlen($fjalekalimi) < 6) {
        $error = "Fjalëkalimi duhet të jetë të paktën 6 karaktere.";
    }

    if (!$error) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($fjalekalimi, $user['fjalekalimi'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } else {
                $error = "Emaili apo fjalëkalimi i pasaktë!";
            }
        } else {
            $error = "Email-i nuk ekziston!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Kyçu - ADI Conditioner</title>
    <link rel="stylesheet" href="style_login.css" />
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h2>Kyçu</h2>
            <?php if (isset($error)): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required />
            <input type="password" name="fjalekalimi" placeholder="Fjalëkalimi" required />
            <button type="submit">Kyçu</button>
            <p>Nuk ke llogari? <a href="register.php">Regjistrohu</a></p>
        </form>
    </div>
</body>
</html>
