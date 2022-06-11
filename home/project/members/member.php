<!-- Vista con la información de un integrante
Se ve su información (no modificable),
sus tareas asignadas y agrega un botón para agregar una tarea -->
<?php
session_start();

// Se verifica que se haya iniciado sesión
if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../../");
}

// Se verifica que se haya mandado el id del proyecto
if(!isset($_GET['id'])) {
    header("Location: ../../");
}

// Se verifica que se haya mandado el correo del usuario
if(!isset($_GET['usr'])) {
    header("Location: index.php?id=".$_GET['id']);
}

require_once '../../../database/connection.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Task Assigner</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <?php
        require_once '../../../includes/navbar.php';
        
        // Se Verifica que la persona que consulta la información sea administrador o sub administrador
        $puesto = get_puesto(
            $_SESSION['correo_usr'],
            $_GET['id']
        );

        if($puesto == null) {
            header("Location: ../");
        }
        if(strcmp($puesto, "Empleado") == 0) {
            header("Location: ../");
        }
        ?>
    </body>
    <?php
    require_once '../../../includes/footer.php';
    ?>
</html>