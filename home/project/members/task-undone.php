<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../../");
}

if(!isset($_GET['id'])) {
    header("Location: ../../");
}

if(!isset($_GET['usr'])) {
    header("Location: index.php?id=".$_GET['id']);
}

if(!isset($_GET['task'])) {
    header("Location: member.php?id=".$_GET['id']."&usr=".$_GET['usr']);
}

require_once '../../../database/connection.php';

// Se valida que el usuario es administrador o sub administrador
$puesto = get_puesto(
    $_SESSION['correo_usr'],
    $_GET['id']
);

if($puesto == null) {
    header("Location: ../../");
}

if(strcmp($puesto, "Empleado") == 0) {
    header("Location: ../");
}

$actualizar = task_undone(
    $_GET['usr'],
    $_GET['id'],
    $_GET['task']
);

if(!$actualizar) {
    echo "<script>alert('Error al desmarcar la tarea')</script>";
}
header("Location: member.php?id=".$_GET['id']."&usr=".$_GET['usr']."#tareas");
?>