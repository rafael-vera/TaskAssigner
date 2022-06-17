<?php
session_start();

if (!isset($_SESSION['correo_usr'])) {
    header("Location: ../");
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
}

require_once '../database/connection.php';

$puesto = get_puesto(
    $_SESSION['correo_usr'],
    $_GET['id']
);

if($puesto == null) {
    header("Location: index.php");
}

if(strcmp($puesto, "Administrador") != 0) {
    header("Location: index.php");
}

$eliminar = delete_project(
    $_GET['id']
);

if(!$eliminar) {
    echo "<script>alert('Error al eliminar la tarea')</script>";
}
header("Location: index.php");
?>