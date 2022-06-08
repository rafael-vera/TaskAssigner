<?php
session_start();

require_once 'database/connection.php';

if (isset($_SESSION['correo_usr'])) {
    header("Location: home/");
}

if (isset($_POST['submit'])) {
    if($_POST['contrasena_usr'] != $_POST['confirm_contrasena_usr']) {
        echo "<script>alert('La contraseña no es igual')</script>";
    } else {
        $val = sign_up(
            $_POST['nombre_usr'],
            $_POST['apellidos_usr'],
            $_POST['correo_usr'],
            $_POST['contrasena_usr']
        );
    
        if ($val) {
            $_SESSION['correo_usr'] = $_POST['correo_usr'];
            header("Location: home/");
        } else {
            echo "<script>alert('Error al realizar el registro')</script>";
        }
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
        <nav class="navbar navbar-light bg-primary fixed-top">
            <div class="container-fluid">
                <a href="/taskassigner/" class="navbar-brand text-white">Task Assigner</a>
            </div>
        </nav>
        
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Registro</h3>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floating-name" name="nombre_usr" required>
                                            <label for="floating-name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floating-lastname" name="apellidos_usr" required>
                                            <label for="floating-lastname">Apellidos</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo_usr" required>
                                    <label for="floating-email">Correo</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floating-password" name="contrasena_usr" required>
                                    <label for="floating-password">Contraseña</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floating-password" name="confirm_contrasena_usr" required>
                                    <label for="floating-password">Confirma contraseña</label>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Registrarse</button>

                                <hr class="my-4">
                                <div>
                                    <p class="mb-0">¿Ya tienes una cuenta? <a href="index.php">Inicia sesión</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    require_once 'includes/footer.html';
    ?>
</html>