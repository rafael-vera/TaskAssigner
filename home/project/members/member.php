<!-- Vista con la información de un integrante
Se ve su información (no modificable),
sus tareas asignadas y agrega un botón para agregar una tarea -->
<?php
session_start();
require_once '../../../database/connection.php';

// Se verifica que se haya iniciado sesión
if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../../");
}

// Se verifica que se haya mandado el id del proyecto
if(!isset($_GET['id'])) {
    header("Location: ../../");
}

// Se verifica que se haya mandado el correo del usuario
if(!isset($_GET['usr'])) {
    header("Location: index.php?id=".$_GET['id']);
}

if (isset($_POST['submit'])) {
    $val = actualizar_puesto(
        $_GET['usr'],
        $_GET['id'],
        $_POST['puesto']
    );
    if($val){
        header("Location: index.php?id=".$_GET['id']);
    } else{
        echo "<script>alert('Error al realizar el registro')</script>";
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
        
        // Se Verifica que la persona que consulta la información sea administrador o sub administrador
        $puesto = get_puesto(
            $_SESSION['correo_usr'],
            $_GET['id']
        );
        

        if($puesto == null) {
            header("Location: ../");
        }
        if(strcmp($puesto, "Empleado") == 0) {
            header("Location: ../");
        }

        $puestoEmpleado = get_puesto(
            $_GET['usr'],
            $_GET['id']
        );

        $usuario = get_usuario($_GET['usr']);

        ?>
        
        <section class="vh-75">
            <div class="container py-5">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg bg-light">
                            <form action="" method="POST" class="card-body p-5 text-center">
                                <h3 class="mb-5">Datos del usuario del proyecto</h3>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floating-email" name="nombre_usr" disabled required value="<?php echo $usuario["nombre_usr"]." ".$usuario["apellidos_usr"];?>">
                                    <label for="floating-text">Nombre</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floating-email" name="correo" disabled required value="<?php echo $usuario["correo_usr"]; ?>">
                                    <label for="floating-email">Correo</label>
                                </div>

                                <div class="row">
                                <div class="col-md-2 mb-3 my-auto">
                                <label>
                                    Puesto:
                                </label>
                                </div>
                                <div class="col-md-10 mb-3">
                                <select class="form-select my-auto" aria-label="Default select example" name="puesto">
                                    <option value="2" <?php if($puestoEmpleado == "Sub Administrador"){echo 'selected';} ?>>Sub Administrador</option>
                                    <option value="3" <?php if($puestoEmpleado == "Empleado"){echo 'selected';} ?>>Empleado</option>
                                </select>
                                </div>
                                </div>

                                <div class="d-flex justify-content-evenly">
                                        <?php echo '<a href="index.php?id='.$_GET['id'].'" class="btn btn-danger btn-lg btn-block">Cancelar</a>';?>
                                        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Actualizar</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <?php
        // Obtener tareas para este usuario
        $tareas = get_tareas(
            $_GET['usr'],
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
        <section>
            <h1 style="text-align: center;">Tareas</h1>
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
                                    <a href="task-done.php?id='.$_GET['id'].'&task='.$pendientes['nombre'][$i].'" class="btn        btn-success"><i class="fa fa-check text-white" aria-hidden="true"> Realizado</i></a>
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
                                    <a href="task-undone.php?id='.$_GET['id'].'&task='.$completadas['nombre'][$i].'" class="btn         btn-danger"><i class="fa fa-times" aria-hidden="true"> No realizado</i></a>
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
                                    <a href="task-done.php?id='.$_GET['id'].'&task='.$atrasadas['nombre'][$i].'" class="btn         btn-success"><i class="fa fa-check text-white" aria-hidden="true"> Realizado</i></a>
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
        </section>
        <br/><br/><br/>
    </body>
    <?php
    require_once '../../../includes/footer.php';
    ?>
</html>