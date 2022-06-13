<?php

use function PHPSTORM_META\type;

    function connection() {
        $SERVER   = '127.0.0.1';
        $USER     = 'root';
        $PASSWD   = '';
        $DATABASE = 'taskassignerdb';
        $PORT     = 3306;
        $conn = mysqli_connect($SERVER, $USER, $PASSWD, $DATABASE, $PORT);
        if($conn->connect_errno){
            die("Connection error");
        } else {
            return $conn;
        }
    }

    function close_connection($conn) {
        $conn->close();
    }

    function login($email, $passwd) {
        $val = false;
        $conn = connection();
        $result = $conn->query(
            "SELECT * FROM usuario WHERE correo_usr='$email' AND contrasena_usr='$passwd'"
        );
        if($result->num_rows > 0) {
            $val = true;
        }
        close_connection($conn);
        return $val;
    }

    function sign_up($name, $lastname, $email, $passwd) {
        $val = false;
        $conn = connection();
        $sql = "INSERT INTO usuario (correo_usr, nombre_usr, apellidos_usr, contrasena_usr) VALUES ('$email', '$name', '$lastname', '$passwd')";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function create_project($email, $nom_proyecto, $desc_proyecto=''){
        $val = false;
        $conn = connection();
        $sql = "INSERT INTO proyecto VALUES (NULL, '$nom_proyecto', '$desc_proyecto')";
        try {
            if($conn->query($sql)) {
                $new_id = $conn->insert_id;
                $sql = "INSERT INTO usuarioproyecto VALUES ('$email', 1, $new_id)";
                if($conn->query($sql)) {
                    $val = true;
                }
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function get_projects($email) {
        $projects = array(
            'id'=>array(),
            'nombre'=>array(),
            'descripcion'=>array()
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT proyecto.id_proyecto, proyecto.nom_proyecto, proyecto.desc_proyecto FROM proyecto, usuarioproyecto
             WHERE proyecto.id_proyecto = usuarioproyecto.id_proyecto AND usuarioproyecto.correo_usr = '$email'"
        );
        if($result->num_rows > 0) {
            while($project = $result->fetch_row()) {
                array_push($projects['id'], $project[0]);
                array_push($projects['nombre'], $project[1]);
                array_push($projects['descripcion'], $project[2]);
            }
        }
        close_connection($conn);
        return $projects;
    }

    function get_puesto($email, $id) {
        $val = null;
        $conn = connection();
        $result = $conn->query(
            "SELECT nom_puesto FROM puesto, usuarioproyecto
             WHERE usuarioproyecto.correo_usr='$email' AND usuarioproyecto.id_proyecto=$id AND puesto.id_puesto=usuarioproyecto.id_puesto"
        );
        if($result->num_rows > 0) {
            $val = $result->fetch_row()[0];
        }
        close_connection($conn);
        return $val;
    }

    function get_tareas($email, $id) {
        $tareas = array(
            'nombre'=>array(),
            'descripcion'=>array(),
            'fecha'=>array(),
            'terminado'=>array()
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT nom_tarea, desc_tarea, fec_lim_tarea, terminado FROM tarea
             WHERE correo_usr='$email' AND id_proyecto=$id ORDER BY fec_lim_tarea ASC"
        );
        if($result->num_rows > 0) {
            while($tarea = $result->fetch_row()) {
                array_push($tareas['nombre'], $tarea[0]);
                array_push($tareas['descripcion'], $tarea[1]);
                array_push($tareas['fecha'], $tarea[2]);
                array_push($tareas['terminado'], $tarea[3]);
            }
        }
        close_connection($conn);
        return $tareas;
    }

    function task_done($email, $id, $task) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE tarea SET terminado=1 WHERE nom_tarea='$task' AND correo_usr='$email' AND id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function task_undone($email, $id, $task) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE tarea SET terminado=0 WHERE nom_tarea='$task' AND correo_usr='$email' AND id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function get_integrantes($id_proyecto) {
        $integrantes = array(
            'correo'=>array(),
            'nombre'=>array(),
            'apellidos'=>array(),
            'puesto'=>array()
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT usuario.correo_usr, usuario.nombre_usr, usuario.apellidos_usr, puesto.nom_puesto FROM usuarioproyecto, usuario, puesto
             WHERE usuarioproyecto.id_proyecto=$id_proyecto AND usuarioproyecto.id_puesto=puesto.id_puesto AND usuarioproyecto.correo_usr=usuario.correo_usr"
        );
        if($result->num_rows > 0) {
            while($integrante = $result->fetch_row()) {
                array_push($integrantes['correo'], $integrante[0]);
                array_push($integrantes['nombre'], $integrante[1]);
                array_push($integrantes['apellidos'], $integrante[2]);
                array_push($integrantes['puesto'], $integrante[3]);
            }
        }
        close_connection($conn);
        return $integrantes;
    }

    function add_integrante($email, $puesto, $id) {
        $val = false;
        $conn = connection();
        $sql = "INSERT INTO usuarioproyecto VALUES ('$email', '$puesto', '$id')";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function delete_integrante($email, $id) {
        $val = false;
        $conn = connection();
        $sql = "DELETE FROM usuarioproyecto WHERE correo_usr='$email' AND id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function get_usuario($email){
        $conn = connection();
        $result = $conn->query(
            "SELECT * FROM `usuario` WHERE `correo_usr` ='$email'"
        );
        $res = array("correo_usr" => "", "nombre_usr" => "", "apellidos_usr"=>"");
        
        if($result->num_rows > 0) {
            while($integrante = $result->fetch_row()) {
                $res['correo_usr'] = $integrante[0];
                $res['nombre_usr'] = $integrante[1];
                $res['apellidos_usr'] = $integrante[2];
            }
        }
        close_connection($conn);
        return $res;
    }

    function actualizar_puesto($email,$idproyecto,$puesto){
        $val = false;
        $conn = connection();

        $result = $conn->query(
            "UPDATE `usuarioproyecto` SET `id_puesto`='$puesto' WHERE `correo_usr`= '$email' AND `id_proyecto` = '$idproyecto'"
        );
        
        if($result){
            $val = true;
        }

        close_connection($conn);
        return $val;
    }
?>