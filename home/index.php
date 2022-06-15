<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../");
}

require_once '../database/connection.php';

$projects = get_projects($_SESSION['correo_usr']);
$num_projects = count($projects['id']);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Task Assigner</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php
        require_once '../includes/navbar.php';

        if(!( $num_projects > 0 )) {
            // En caso de que no haya proyectos
            require_once 'no-projects.php';
        } else {
            // En caso de que sí haya proyectos
            require_once 'grid-cards.php';
        }
        ?>
    </body>
    <?php
    require_once '../includes/footer.php';
    ?>
</html>