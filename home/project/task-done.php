<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../../");
}

if(!isset($_GET['id'])) {
    header("Location: ../");
}

if(!isset($_GET['task'])) {
    header("Location: index.php?id=".$_GET['id']);
}

require_once '../../database/connection.php';

$actualizar = task_done(
    $_SESSION['correo_usr'],
    $_GET['id'],
    $_GET['task']
);

if(!$actualizar) {
    echo "<script>alert('Error al completar la tarea')</script>";
}
header("Location: index.php?id=".$_GET['id']);
?>