<!-- Vista del empleado donde solo puede ver sus tareas -->
<?php
// Obtener tareas para este usuario
$tareas = get_tareas(
    $_SESSION['correo_usr'],
    $_GET['id']
);

$pendientes = array(
    'nombre'=>array(),
    'descripcion'=>array(),
    'fecha'=>array(),
    'terminado'=>array()
);
$completadas = array(
    'nombre'=>array(),
    'descripcion'=>array(),
    'fecha'=>array(),
    'terminado'=>array()
);
$atrasadas = array(
    'nombre'=>array(),
    'descripcion'=>array(),
    'fecha'=>array(),
    'terminado'=>array()
);

$num_total = count($tareas['nombre']);
if($num_total > 0) {
    $i = 0;
    $fecha_actual = new DateTime();
    $fecha_actual = $fecha_actual->format('Y-m-d');
    while($i < $num_total) {
        $fecha_tarea = new DateTime($tareas['fecha'][$i]);
        $fecha_tarea = $fecha_tarea->format('Y-m-d');
        if($tareas['terminado'][$i] != 0) {
            array_push($completadas['nombre'], $tareas['nombre'][$i]);
            array_push($completadas['descripcion'], $tareas['descripcion'][$i]);
            array_push($completadas['fecha'], $tareas['fecha'][$i]);
            array_push($completadas['terminado'], $tareas['terminado'][$i]);
        } else if($fecha_actual > $fecha_tarea) {
            array_push($atrasadas['nombre'], $tareas['nombre'][$i]);
            array_push($atrasadas['descripcion'], $tareas['descripcion'][$i]);
            array_push($atrasadas['fecha'], $tareas['fecha'][$i]);
            array_push($atrasadas['terminado'], $tareas['terminado'][$i]);
        } else {
            array_push($pendientes['nombre'], $tareas['nombre'][$i]);
            array_push($pendientes['descripcion'], $tareas['descripcion'][$i]);
            array_push($pendientes['fecha'], $tareas['fecha'][$i]);
            array_push($pendientes['terminado'], $tareas['terminado'][$i]);
        }
        $i++;
    }
}
?>
<main class="container p-5">
    <h1>Tareas</h1>
    <hr>
    <div class="row mx-2 d-flex justify-content-evenly">
        <div class="card shadow col mx-3" style="background-color: #fff054;">
            <h4 class="mt-3 text-center">
                Pendientes
                <hr>
            </h4>
            <div style="overflow-x: hidden; overflow-y: auto; height: 400px;">
            <?php
            $i = 0;
            $total = count($pendientes['nombre']);
            while($i < $total) {
                echo '
                <div class="card bg-light m-1">
                    <h6 class="card-header">'.$pendientes['nombre'][$i].'</h6>
                    <div class="card-body">
                        <p>'.$pendientes['descripcion'][$i].'</p>
                        <div class="d-flex justify-content-between">
                            <p class="my-auto">'.$pendientes['fecha'][$i].'</p>
                            <a href="task-done.php?id='.$_GET['id'].'&task='.$pendientes['nombre'][$i].'" class="btn btn-success"><i class="fa fa-check text-white" aria-hidden="true"> Realizado</i></a>
                        </div>
                    </div>
                </div>
                ';
                $i++;
            }
            ?>
            </div>
        </div>
        <div class="card shadow col mx-3" style="background-color: #44a97a;">
            <h4 class="mt-3 text-center">
                Completadas
                <hr>
            </h4>
            <div style="overflow-x: hidden; overflow-y: auto; height: 400px;">
            <?php
            $i = 0;
            $total = count($completadas['nombre']);
            while($i < $total) {
                echo '
                <div class="card bg-light m-1">
                    <h6 class="card-header">'.$completadas['nombre'][$i].'</h6>
                    <div class="card-body">
                        <p>'.$completadas['descripcion'][$i].'</p>
                        <div class="d-flex justify-content-between">
                            <p class="my-auto">'.$completadas['fecha'][$i].'</p>
                            <a href="task-undone.php?id='.$_GET['id'].'&task='.$completadas['nombre'][$i].'" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"> No realizado</i></a>
                        </div>
                    </div>
                </div>
                ';
                $i++;
            }
            ?>
            </div>
        </div>
        <div class="card shadow col mx-3" style="background-color: #f65564;">
            <h4 class="mt-3 text-center">
                Atrasadas
                <hr>
            </h4>
            <div style="overflow-x: hidden; overflow-y: auto; height: 400px;">
            <?php
            $i = 0;
            $total = count($atrasadas['nombre']);
            while($i < $total) {
                echo '
                <div class="card bg-light m-1">
                    <h6 class="card-header">'.$atrasadas['nombre'][$i].'</h6>
                    <div class="card-body">
                        <p>'.$atrasadas['descripcion'][$i].'</p>
                        <div class="d-flex justify-content-between">
                            <p class="my-auto">'.$atrasadas['fecha'][$i].'</p>
                            <a href="task-done.php?id='.$_GET['id'].'&task='.$atrasadas['nombre'][$i].'" class="btn btn-success"><i class="fa fa-check text-white" aria-hidden="true"> Realizado</i></a>
                        </div>
                    </div>
                </div>
                ';
                $i++;
            }
            ?>
            </div>
        </div>
    </div>
</main>