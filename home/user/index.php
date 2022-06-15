<!-- Vista para que el usuario visualice su información y pueda modificarla -->
<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../");
}

require_once '../../database/connection.php';

$user = get_usuario(
    $_SESSION['correo_usr']
);

// Submit
if (isset($_POST['submit'])) {
    $val = update_info_usuario(
        $_SESSION['correo_usr'],
        $_POST['nombre_usr'],
        $_POST['apellidos_usr']
    );

    if($val) {
        $user = get_usuario(
            $_SESSION['correo_usr']
        );
    } else {
        echo "<script>alert('Fallo la modificación')</script>";
    }
}
if (isset($_POST['update'])) {
    if(strcmp($_POST['new_contrasena_usr'], $_POST['confirm_contrasena_usr']) == 0) {
        $val = login(
            $_SESSION['correo_usr'],
            $_POST['old_contrasena_usr']
        );

        if($val) {
            $val2 = update_pswd_usuario(
                $_SESSION['correo_usr'],
                $_POST['new_contrasena_usr']
            );

            if(!$val2) {
                echo "<script>alert('Error al actualizar la contraseña')</script>";
            }
        } else {
            echo "<script>alert('Contraseña incorrecta')</script>";
        }
    } else {
        echo "<script>alert('La contraseña no es igual')</script>";
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
        require_once '../../includes/navbar.php';
        ?>
        <section class="vh-75 mb-5">
            <div class="container py-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Perfil de usuario<hr></h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floating-name" name="nombre_usr" maxlength="50" value="<?php echo $user['nombre_usr']; ?>" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,32}$" required>
                                            <label for="floating-name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floating-lastname" name="apellidos_usr" maxlength="50" value="<?php echo $user['apellidos_usr']; ?>" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,32}$" required>
                                            <label for="floating-lastname">Apellidos</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo_usr" maxlength="50" value="<?php echo $user['correo_usr']; ?>" disabled>
                                    <label for="floating-email">Correo</label>
                                </div>
                                <div class="d-flex justify-content-evenly">
                                    <a href="../" class="btn btn-secondary btn-lg btn-block">Volver</a>
                                    <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Actualizar</button>
                                </div>
                            </form>
                            <hr class="m-0">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Cambiar contraseña</h3>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floating-password" name="new_contrasena_usr" maxlength="20" required>
                                    <label for="floating-password">Nueva contraseña</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floating-password" name="confirm_contrasena_usr" maxlength="20" required>
                                    <label for="floating-password">Confirma contraseña</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floating-password" name="old_contrasena_usr" maxlength="20" required>
                                    <label for="floating-password">Anterior contraseña</label>
                                </div>
                                <button class="btn btn-primary btn-lg btn-block" name="update" type="submit">Cambiar contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    require_once '../../includes/footer.php';
    ?>
</html>