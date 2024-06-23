<!--Naglowek-->
<h1>Blog</h1>
<div class="welcome-message">
    <?php
    // Wyswietlenie nazwy uzytkownika
    if(isset($_SESSION['username'])) {
        echo '<p>Witaj, ' . $_SESSION['username'] . '!</p>';
    }
    ?>
</div>
<!--Panel nawigacyjny-->
<nav>
    <a href="index.php">Strona Główna</a>
    <a href="create_post.php">Dodaj post</a>
    <?php
    // Wyswietlenie panelu w zaleznosci od stanu sesji
    if (isset($_SESSION['username']) && $_SESSION['role'] != 'guest') {
        echo '<a href="admin_panel.php">Panel Administracyjny</a>';
        echo '<a href="account.php">Konto</a>';
        echo '<a href="logout.php">Wyloguj</a>';
    } else {
        echo '<a href="register.php">Zarejestruj</a>';
        echo '<a href="login.php">Zaloguj</a>';
    }
    ?>
</nav>
<br>