<!-- Vista del formulario para agregar un integrante al proyecto -->
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

if (isset($_POST['submit'])) {
    if(filter_var($_POST['correo_usr'], FILTER_VALIDATE_EMAIL)){
        if($_POST['puesto']!=1){
            $val = add_integrante(
                $_POST['correo_usr'],
                $_POST['puesto'],
                $_GET['id']
            );
            if($val){
                header("Location: index.php?id=".$_GET['id']);
            } else{
                echo "<script>alert('Error al realizar el registro')</script>";
            }
        } else {
            echo "<script>alert('Puesto no valido')</script>";
        }
    } else {
        echo "<script>alert('Correo no valido')</script>";
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
        ?>
        
        <section class="vh-75">
            <div class="container py-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Nuevo usuario del proyecto</h3>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo_usr" maxlength="50" required>
                                    <label for="floating-email">Correo</label>
                                </div>

                                <div class="d-flex justify-content-evenly my-3">
                                    <div class="my-auto px-3">
                                        <label justify-content-center>
                                            Puesto:
                                        </label>
                                    </div>
                                    <select class="form-select" aria-label="Default select example" name="puesto">
                                        <option value="2">Sub Administrador</option>
                                        <option value="3" selected>Empleado</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-evenly">
                                        <?php echo '<a href="index.php?id='.$_GET['id'].'" class="btn btn-danger btn-lg btn-block">Cancelar</a>';?>
                                        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Registrar</button>
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