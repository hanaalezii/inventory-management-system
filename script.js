document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggleBtns = document.querySelectorAll(".sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");
    const themeToggleBtn = document.querySelector(".theme-toggle");
    const themeIcon = themeToggleBtn.querySelector(".theme-icon");
    const menuLinks = document.querySelectorAll(".menu-link");

    const updateThemeIcon = () => {
        const isDark = document.body.classList.contains("dark-theme");
        themeIcon.textContent = sidebar.classList.contains("collapsed") ? (isDark ? "light_mode" : "dark_mode") : "dark_mode";
    };

    const savedTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const shouldUseDarkTheme = savedTheme === "dark" || (!savedTheme && systemPrefersDark);
    document.body.classList.toggle("dark-theme", shouldUseDarkTheme);
    updateThemeIcon();

    themeToggleBtn.addEventListener("click", () => {
        const isDark = document.body.classList.toggle("dark-theme");
        localStorage.setItem("theme", isDark ? "dark" : "light");
        updateThemeIcon();
    });

    sidebarToggleBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            updateThemeIcon();
        });
    });
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            if (confirm('A jeni i sigurt që dëshironi të dilni?')) {
                window.location.href = 'logout.php';
            }
        });
    }
});

searchForm.addEventListener("click", () => {
    if (sidebar.classList.contains("collapsed")) {
        sidebar.classList.remove("collapsed");
        searchForm.querySelector("input").focus();
    }
});


if (window.innerWidth > 768) sidebar.classList.remove("collapsed");