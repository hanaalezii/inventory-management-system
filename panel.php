<?php

$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADI Conditioner - Paneli Admin</title>
    <link rel="stylesheet" href="style.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=photo_library" />
</head>

<body>


    <nav class="site-nav">
        <button class="sidebar-toggle">
            <span class="material-symbols-rounded">menu</span>
        </button>
    </nav>

    <div class="container">

        <aside class="sidebar collapsed">

            <div class="sidebar-header">
                <div class="welcome-text">
                    MIRËSERDHE, <?= strtoupper(htmlspecialchars($_SESSION['user']['emri'])) ?> 😊
                </div>
                <button class="sidebar-toggle" aria-label="Toggle Sidebar">
                    <span class="material-symbols-rounded">chevron_left</span>
                </button>
            </div>

            <div class="sidebar-content">

                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="index.php" class="menu-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                            <span class="material-symbols-rounded">dashboard</span>
                            <span class="menu-label">Paneli Kryesor</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="produktet.php" class="menu-link <?= ($current_page == 'produktet.php') ? 'active' : '' ?>">
                            <span class="material-symbols-rounded">storefront</span>
                            <span class="menu-label">Produktet</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="porosite.php" class="menu-link <?= ($current_page == 'porosite.php') ? 'active' : '' ?>">
                            <span class="material-symbols-rounded">shopping_cart</span>
                            <span class="menu-label">Porositë</span>
                        </a>

                    <li class="menu-item">
                        <a href="rrethnesh.php" class="menu-link <?= ($current_page == 'rrethnesh.php') ? 'active' : '' ?>">
                            <span class="material-symbols-rounded">group</span>
                            <span class="menu-label">Rreth Nesh</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="galeria.php" class="menu-link <?= ($current_page == 'galeria.php') ? 'active' : '' ?> ">
                            <span class="material-symbols-outlined">photo_library</span>
                            <span class="menu-label">Galeria</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="pagesat.php" class="menu-link <?= ($current_page == 'pagesat.php') ? 'active' : '' ?> ">
                            <span class="material-symbols-rounded">payments</span>
                            <span class="menu-label">Pagesat</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="raportet.php" class="menu-link <?= ($current_page == 'raportet.php') ? 'active' : '' ?>">
                            <span class="material-symbols-rounded">analytics</span>
                            <span class="menu-label">Raportet</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <button class="theme-toggle" id="theme-toggle-btn">
                    <div class="theme-label">
                        <span class="theme-icon material-symbols-rounded">dark_mode</span>
                        <span class="theme-text">Modaliteti</span>
                    </div>
                    <div class="theme-toggle-track">
                        <div class="theme-toggle-indicator"></div>
                    </div>
                </button>

                <button class="theme-toggle" id="logout-btn" type="button" style="margin-top: 10px;">
                    <div class="theme-label">
                        <span class="theme-icon material-symbols-rounded">logout</span>
                        <span class="theme-text">Dil</span>
                    </div>
                </button>
            </div>

        </aside>

        <script src="script.js"></script>
</body>

</html>