<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: /taskassigner/");
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Task Assigner</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-light bg-primary fixed-top">
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
    </body>
    <?php
    require_once '../includes/footer.html';
    ?>
</html>