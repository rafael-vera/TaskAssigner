<!-- Script que elimina un integrante de un proyecto -->
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

require_once '../../../database/connection.php';

$puesto = get_puesto(
    $_SESSION['correo_usr'],
    $_GET['id']
);
// Si el usuario no pertenece al proyecto lo regresa a home
if($puesto == null) {
    header("Location: ../../");
}
// Si el usuario no es administrador o sub administrador del proyecto lo regresa a project
if(strcmp($puesto, "Empleado") == 0) {
    header("Location: ../?id=".$_GET['id']);
}

// Si todo es correcto, elimina al usuario
$eliminar = delete_integrante(
    $_GET['usr'],
    $_GET['id']
);

if($eliminar) {
    echo "<script>alert('Error al eliminar al integrante')</script>";
}
header("Location: index.php?id=".$_GET['id']);
?>