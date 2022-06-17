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
        <main class="container p-5">
            <div class="d-flex justify-content-between">
                <h1>Sobre nosotros</h1>
                <h5 class="my-auto">Equipo 1201</h5>
            </div>
            <hr>
            <div class="row">
                <div class="col mx-8 d-flex justify-content-center">
                    <div class="card w-100 shadow">
                        <img src="images/marco.jpg" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Marco Gabriel Cortés Toledo</h5>
                            <p class="card-text">E18020767</p>
                        </div>
                    </div>
                </div>

                <div class="col mx-8 d-flex justify-content-center">
                    <div class="card w-100 shadow">
                        <img src="images/rafael.jpeg" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Rafael de Jesús Vera Reyes</h5>
                            <p class="card-text">E18020791</p>
                        </div>
                    </div>
                </div>

                <div class="col mx-8 d-flex justify-content-center">
                    <div class="card w-100 shadow">
                        <img src="images/andres.jpeg" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Jesús Andrés Lagunes Hernández</h5>
                            <p class="card-text">E18020808</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <?php
    require_once 'includes/footer.php';
    ?>
</html>