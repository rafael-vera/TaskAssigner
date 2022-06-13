<!-- Vista con la información de un integrante
Se ve su información (no modificable),
sus tareas asignadas y agrega un botón para agregar una tarea -->
<?php
session_start();
require_once '../../../database/connection.php';

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

if (isset($_POST['submit'])) {
    $val = actualizar_puesto(
        $_GET['usr'],
        $_GET['id'],
        $_POST['puesto']
    );
    if($val){
        header("Location: index.php?id=".$_GET['id']);
    } else{
        echo "<script>alert('Error al realizar el registro')</script>";
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
        
        $puestoEmpleado = get_puesto(
            $_GET['usr'],
            $_GET['id']);
        
        if($puesto == null) {
            header("Location: ../");
        }
        if(strcmp($puesto, "Empleado") == 0) {
            header("Location: ../");
        }

        $usuario = get_usuario($_GET['usr']);

        ?>
        
        <section class="vh-75">
            <div class="container py-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Datos del usuario del proyecto</h3>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floating-email" name="nombre_usr" disabled required value="<?php echo $usuario["nombre_usr"]." ".$usuario["apellidos_usr"];?>">
                                    <label for="floating-text">Nombre</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo" disabled required value="<?php echo $usuario["correo_usr"]; ?>">
                                    <label for="floating-email">Correo</label>
                                </div>

                                <div class="row">
                                <div class="col-md-2 mb-3 my-auto">
                                <label>
                                    Puesto:
                                </label>
                                </div>
                                <div class="col-md-10 mb-3">
                                <select class="form-select my-auto" aria-label="Default select example" name="puesto">
                                    <option value="2" <?php if($puestoEmpleado == "Sub Administrador"){echo 'selected';} ?>>Sub Administrador</option>
                                    <option value="3" <?php if($puestoEmpleado == "Empleado"){echo 'selected';} ?>>Empleado</option>
                                </select>
                                </div>
                                </div>

                                <div class="d-flex justify-content-evenly">
                                        <?php echo '<a href="index.php?id='.$_GET['id'].'" class="btn btn-danger btn-lg btn-block">Cancelar</a>';?>
                                        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Actualizar</button>
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