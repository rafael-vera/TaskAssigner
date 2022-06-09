<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: /taskassigner/");
}

require_once '../database/connection.php';

if (isset($_POST['submit'])) {
    $val = create_projects($_POST['nom_proyecto'], $_POST['desc_proyecto']);
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
        require_once '../includes/navbar.php';
        ?>
        <section class="vh-75">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Crear un Proyecto</h3>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floating-name" name="nom_proyecto" required>
                                            <label for="floating-name">Nombre del Proyecto</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <textarea type="text" class="form-control " id="floating-desc" name="desc_proyecto" required rows="20"></textarea>
                                            <label for="floating-desc">Descripción del Proyecto</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-evenly">
                                    <a href="../" class="btn btn-danger btn-lg btn-block">Cancelar</a>
                                    <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Crear Proyecto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    require_once '../includes/footer.php';
    ?>
</html>