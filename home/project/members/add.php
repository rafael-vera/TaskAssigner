<!-- Vista del formulario para agregar un integrante al proyecto -->
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
        
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg bg-light">
                        <form action="" method="POST" class="card-body p-5 text-center">
                            <h3 class="mb-5">Nuevo usuario del proyecto</h3>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floating-email" name="correo_usr" required>
                                <label for="floating-email">Correo</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floating-puesto" name="id_puesto" required>
                                <label for="floating-puesto">Puesto</label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Registrar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
    require_once '../../../includes/footer.php';
    ?>
</html>