<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../");
}

if(!isset($_GET['id'])) {
    header("Location: ../");
}

require_once '../../database/connection.php';
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
        require_once '../../includes/navbar.php';
        
        $puesto = get_puesto(
            $_SESSION['correo_usr'],
            $_GET['id']
        );

        if($puesto == null) {
            header("Location: ../");
        }

        if(strcmp($puesto, "Empleado") == 0) {
            require_once 'employee.php';
        } else {
            require_once 'administrator.php';
        }
        ?>
    </body>
    <?php
    require_once '../../includes/footer.php';
    ?>
</html>