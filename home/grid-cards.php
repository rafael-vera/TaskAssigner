<main class="container p-5">
    <div class="d-flex justify-content-between">
        <h1>Proyectos</h1>
        <div class="my-auto">
            <a href="new-project.php" class="btn btn-success">
                <i class="fa fa-plus-circle" aria-hidden="true"> Nuevo proyecto</i>
            </a>
        </div>
    </div>
    <hr>
    <?php
    $i = 0;
    do {
        echo '<div class="row py-4">';
        $cont = 3;
        while($cont > 0 && $num_projects > 0) {
            $puesto = get_puesto(
                $_SESSION['correo_usr'],
                $projects['id'][$i]
            );
            echo '
            <div class="col mx-5 d-flex justify-content-center">
                <div class="card w-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title">'.$projects['nombre'][$i].'</h5>
                        <p class="card-text">'.$projects['descripcion'][$i].'</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="project/?id='.$projects['id'][$i].'" class="btn btn-info" data-toggle="tooltip" title="Ver proyecto"><i class="fa fa-eye" aria-hidden="true"> Ver</i></a>';
            if(strcmp($puesto, "Administrador") == 0) {
                echo '
                            <a href="edit-project.php?id='.$projects['id'][$i].'" class="btn btn-warning" data-toggle="tooltip" title="Editar proyecto"><i class="fa fa-pencil" aria-hidden="true"> Editar</i></a>
                            <a href="delete-project.php?id='.$projects['id'][$i].'" class="btn btn-danger" data-toggle="tooltip" title="Eliminar proyecto"><i class="fa fa-trash" aria-hidden="true"> Eliminar</i></a>
                ';
            }
            echo '
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