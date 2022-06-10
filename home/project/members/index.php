<!-- Lista de empleados, esta vista la ve los administradores y sub-administradores -->
<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../../");
}

if(!isset($_GET['id'])) {
    header("Location: ../../");
}

require_once '../../../database/connection.php';

$puesto = get_puesto(
    $_SESSION['correo_usr'],
    $_GET['id']
);
// Si el usuario no pertenece al proyecto lo regresa a home
if($puesto == null) {
    header("Location: ../../");
}
// Si el usuario no es administrador o sub administrador del proyecto lo regresa a project
if(strcmp($puesto, "Empleado") == 0) {
    header("Location: ../?id=".$_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Task Assigner</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
    </head>
    <body>
        <?php
        require_once '../../../includes/navbar.php';

        $integrantes = get_integrantes(
            $_GET['id']
        );
        ?>

        <main class="container p-5">
            <div class="d-flex justify-content-between">
                <h1>Integrantes</h1>
                <div class="my-auto">
                    <a href="#" class="btn btn-success">Agregar integrante</a>
                </div>
            </div>
            <hr>
            <table id="tablaIntegrantes" class="table table-striped table-bordered text-center" >
                <thead>
                    <tr>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Puesto</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Se crea los datos de la tabla
                $i = 0;
                $j = count($integrantes['correo']);
                while($i < $j) {
                    echo '
                        <tr>
                            <td>'.$integrantes['correo'][$i].'</td>
                            <td>'.$integrantes['nombre'][$i].'</td>
                            <td>'.$integrantes['apellidos'][$i].'</td>
                            <td>'.$integrantes['puesto'][$i].'</td>
                        </tr>
                    ';
                    $i++;
                }
                ?>
                </tbody>
            </table>
        <main class="container p-5">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
        <script>
            $(document).ready( function () {
                $('#tablaIntegrantes').DataTable();
            } );
        </script>
    </body>
    <?php
    require_once '../../../includes/footer.php';
    ?>
</html>