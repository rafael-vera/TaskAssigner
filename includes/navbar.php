<nav class="navbar navbar-light bg-primary sticky-top">
    <div class="container-fluid">
        <a href="/taskassigner" class="navbar-brand text-white">Task Assigner</a>
        <?php
        if (isset($_SESSION['correo_usr'])) {
            echo '
            <div>
                <a href="/taskassigner/home/user/" class="navbar-text navbar-brand text-white mx-4 px-3 border border-white border-2 rounded-pill">Ver perfil</a>
                <a href="/taskassigner/logout.php" class="navbar-text navbar-brand text-white px-3 border border-white border-2 rounded-pill">Cerrar sesión</a>
            </div>
            ';
        }
        ?>
    </div>
</nav>