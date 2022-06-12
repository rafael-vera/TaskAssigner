<?php
session_start();

if (isset($_SESSION['correo_usr'])) {
    header("Location: home/");
}

require_once 'database/connection.php';

if (isset($_POST['submit'])) {
    $val = login($_POST['correo_usr'], $_POST['contrasena_usr']);
	if ($val) {
        $_SESSION['correo_usr'] = $_POST['correo_usr'];
		header("Location: home/");
	} else {
		echo "<script>alert('Correo o contraseña incorrectos')</script>";
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
        require_once 'includes/navbar.php';
        ?>

        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg bg-light">
                        <form action="" method="POST" class="card-body p-5 text-center">
                            <h3 class="mb-5">Iniciar sesión</h3>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floating-email" name="correo_usr" required>
                                <label for="floating-email">Correo</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floating-password" name="contrasena_usr" required>
                                <label for="floating-password">Contraseña</label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Ingresar</button>

                            <hr class="my-4">

                            <div>
                                <p class="mb-0">¿No tienes una cuenta? <a href="registro.php">Registrate</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
    require_once 'includes/footer.php';
    ?>
</html>