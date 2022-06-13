<!-- Vista para añadir tareas a los empleados que pertenezcan a un proyecto -->
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

if (isset($_POST['submit'])) {
    $val = add_tarea(
        $_POST['nom_tarea'],
        $_POST['desc_tarea'],
        $_POST['fec_lim_tarea'],
        $_GET['usr'],
        $_GET['id'],
    );

    if($val){
        header("Location: index.php?id=".$_GET['id']);
    } else{
        echo "<script>alert('Error al agregar la tarea')</script>";
    }
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
        <?php
        require_once '../../../includes/navbar.php';
        
        // Se Verifica que la persona que consulta la información sea administrador o sub administrador
        $puesto = get_puesto(
            $_SESSION['correo_usr'],
            $_GET['id']
        );

        if($puesto == null) {
            header("Location: ../../");
        }
        if(strcmp($puesto, "Empleado") == 0) {
            header("Location: ../");
        }

        $puestoEmpleado = get_puesto(
            $_GET['usr'],
            $_GET['id']
        );

        // Se valida que el usuario pertenezca al proyecto
        if($puestoEmpleado == null) {
            header("Location: index.php?id=".$_GET['id']);
        }
        // Se valida que el usuario no sea administrador
        if(strcmp($puestoEmpleado, "Administrador") == 0) {
            header("Location: index.php?id=".$_GET['id']);
        }
        
        $usuario = get_usuario($_GET['usr']);
        ?>
        
        <section class="vh-75 mb-5">
            <div class="container py-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Agregar tarea</h3>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floating-tarea" name="nom_tarea" required>
                                    <label for="floating-tarea">Nombre de la Tarea</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control " id="floating-desc" name="desc_tarea" required rows="30" style="height: 160px"></textarea>
                                    <label for="floating-desc">Descripción de la Tarea</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floating-date" name="fec_lim_tarea" required> 
                                    <label for="floating-date">Fecha límite de la Tarea</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floating-nombre" name="nombre_usr" disabled required value="<?php echo $usuario["nombre_usr"]." ".$usuario["apellidos_usr"];?>">
                                    <label for="floating-nombre">Nombre del integrante</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo" disabled required value="<?php echo $usuario["correo_usr"];?>">
                                    <label for="floating-email">Correo del integrante</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floating-puesto" name="puesto" disabled required value="<?php echo $puestoEmpleado;?>">
                                    <label for="floating-puesto">Puesto del integrante</label>
                                </div>
                                
                                <div class="d-flex justify-content-evenly">
                                        <?php echo '<a href="index.php?id='.$_GET['id'].'" class="btn btn-danger btn-lg btn-block">Cancelar</a>';?>
                                        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Asignar Tarea</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    require_once '../../../includes/footer.php';
    ?>
</html>