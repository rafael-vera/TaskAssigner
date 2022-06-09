<main class="container p-5">
    <div class="d-flex justify-content-between">
        <h1>Proyectos</h1>
        <div class="my-auto">
            <a href="new-project.php" class="btn btn-success">Nuevo proyecto</a>
        </div>
    </div>
    <hr>
    <?php
    $i = 0;
    do {
        echo '<div class="row py-4">';
        $cont = 3;
        while($cont > 0 && $num_projects > 0) {
            echo '
            <div class="col d-flex justify-content-evenly">
                <div class="card w-50 shadow">
                    <div class="card-body">
                        <h5 class="card-title">'.$projects['nombre'][$i].'</h5>
                        <p class="card-text">'.$projects['descripcion'][$i].'</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="proyecto/?id='.$projects['id'][$i].'" class="btn btn-info">Ir al proyecto</a>
                        </div>
                    </div>
                </div>
            </div>
            ';
            $cont--;
            $num_projects--;
            $i++;
        }
        echo '</div>';
    } while($num_projects > 0);
    ?>
</main>