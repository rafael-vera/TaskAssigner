<nav class="navbar navbar-light bg-primary sticky-top">
    <div class="container-fluid">
        <a href="/taskassigner/" class="navbar-brand text-white">Task Assigner</a>
        <?php
        if (isset($_SESSION['correo_usr'])) {
            echo '
            <a href="../logout.php" class="navbar-text navbar-brand text-white">Cerrar sesión</a>
            ';
        }
        ?>
    </div>
</nav>