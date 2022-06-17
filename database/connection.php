<?php
    function connection() {
        $SERVER   = 'localhost';
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
            "SELECT * FROM Usuario WHERE correo_usr='$email' AND contrasena_usr='$passwd'"
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
        $sql = "INSERT INTO Usuario (correo_usr, nombre_usr, apellidos_usr, contrasena_usr) VALUES ('$email', '$name', '$lastname', '$passwd')";
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
        $sql = "INSERT INTO Proyecto VALUES (NULL, '$nom_proyecto', '$desc_proyecto')";
        try {
            if($conn->query($sql)) {
                $new_id = $conn->insert_id;
                $sql = "INSERT INTO UsuarioProyecto VALUES ('$email', 1, $new_id)";
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
            "SELECT Proyecto.id_proyecto, Proyecto.nom_proyecto, Proyecto.desc_proyecto FROM Proyecto, UsuarioProyecto
             WHERE Proyecto.id_proyecto = UsuarioProyecto.id_proyecto AND UsuarioProyecto.correo_usr = '$email'"
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

    function get_project($id) {
        $project = array(
            'nombre'=>"",
            'descripcion'=>""
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT nom_proyecto, desc_proyecto FROM Proyecto WHERE id_proyecto=$id"
        );
        if($result->num_rows > 0) {
            $res = $result->fetch_row();
            $project['nombre'] = $res[0];
            $project['descripcion'] = $res[1];
        }
        close_connection($conn);
        return $project;
    }

    function update_project($id, $nombre, $desc) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE Proyecto SET nom_proyecto='$nombre', desc_proyecto='$desc' WHERE id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function delete_project($id) {
        $val = false;
        $conn = connection();
        $sql = "DELETE FROM Proyecto WHERE id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function get_puesto($email, $id) {
        $val = null;
        $conn = connection();
        $result = $conn->query(
            "SELECT nom_puesto FROM Puesto, UsuarioProyecto
             WHERE UsuarioProyecto.correo_usr='$email' AND UsuarioProyecto.id_proyecto=$id AND Puesto.id_puesto=UsuarioProyecto.id_puesto"
        );
        if($result->num_rows > 0) {
            $val = $result->fetch_row()[0];
        }
        close_connection($conn);
        return $val;
    }

    function get_all_tareas($id) {
        $tareas = array(
            'nombre'=>array(),
            'correo'=>array(),
            'descripcion'=>array(),
            'fecha'=>array(),
            'terminado'=>array()
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT nom_tarea, correo_usr, desc_tarea, fec_lim_tarea, terminado FROM Tarea
             WHERE id_proyecto=$id ORDER BY fec_lim_tarea ASC"
        );
        if($result->num_rows > 0) {
            while($tarea = $result->fetch_row()) {
                array_push($tareas['nombre'], $tarea[0]);
                array_push($tareas['correo'], $tarea[1]);
                array_push($tareas['descripcion'], $tarea[2]);
                array_push($tareas['fecha'], $tarea[3]);
                array_push($tareas['terminado'], $tarea[4]);
            }
        }
        close_connection($conn);
        return $tareas;
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
            "SELECT nom_tarea, desc_tarea, fec_lim_tarea, terminado FROM Tarea
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

    function get_tarea($nombre, $email, $id) {
        $tarea = array(
            'descripcion'=>"",
            'fecha'=>""
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT desc_tarea, fec_lim_tarea FROM Tarea
             WHERE nom_tarea='$nombre' AND correo_usr='$email' AND id_proyecto=$id"
        );
        if($result->num_rows > 0) {
            $res = $result->fetch_row();
            $tarea['descripcion'] = $res[0];
            $tarea['fecha'] = $res[1];
        }
        close_connection($conn);
        return $tarea;
    }

    function task_done($email, $id, $task) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE Tarea SET terminado=1 WHERE nom_tarea='$task' AND correo_usr='$email' AND id_proyecto=$id";
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
        $sql = "UPDATE Tarea SET terminado=0 WHERE nom_tarea='$task' AND correo_usr='$email' AND id_proyecto=$id";
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
            "SELECT Usuario.correo_usr, Usuario.nombre_usr, Usuario.apellidos_usr, Puesto.nom_puesto FROM UsuarioProyecto, Usuario, Puesto
             WHERE UsuarioProyecto.id_proyecto=$id_proyecto AND UsuarioProyecto.id_puesto=Puesto.id_puesto AND UsuarioProyecto.correo_usr=Usuario.correo_usr"
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
        $sql = "INSERT INTO UsuarioProyecto VALUES ('$email', '$puesto', '$id')";
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
        $sql = "DELETE FROM UsuarioProyecto WHERE correo_usr='$email' AND id_proyecto=$id";
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
        $res = array(
            "correo_usr"=>"",
            "nombre_usr"=>"",
            "apellidos_usr"=>""
        );
        $result = $conn->query(
            "SELECT * FROM Usuario WHERE correo_usr='$email'"
        );
        
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

    function update_info_usuario($email, $nombre, $apellidos) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE Usuario SET nombre_usr='$nombre', apellidos_usr='$apellidos' WHERE correo_usr='$email'";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function update_pswd_usuario($email, $passwd) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE Usuario SET contrasena_usr='$passwd' WHERE correo_usr='$email'";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function actualizar_puesto($email, $idproyecto, $puesto){
        $val = false;
        $conn = connection();
        $sql = "UPDATE UsuarioProyecto SET id_puesto='$puesto' WHERE correo_usr= '$email' AND id_proyecto = $idproyecto";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function add_tarea($nombre_tarea, $desc_tarea, $fecha_lim_tarea, $correo_empleado, $id_proyecto){
        $val = false;
        $conn = connection();
        $sql = "INSERT INTO Tarea (nom_tarea, correo_usr, id_proyecto, desc_tarea, fec_lim_tarea, terminado)
                VALUES ('$nombre_tarea', '$correo_empleado', $id_proyecto, '$desc_tarea', '$fecha_lim_tarea', 0)";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function update_task($nombre_old, $nombre_new, $email, $id, $desc, $fecha) {
        $val = false;
        $conn = connection();
        $sql = "UPDATE Tarea
                SET nom_tarea='$nombre_new', desc_tarea='$desc', fec_lim_tarea='$fecha'
                WHERE nom_tarea='$nombre_old' AND correo_usr='$email' AND id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }

    function delete_task($nombre, $email, $id) {
        $val = false;
        $conn = connection();
        $sql = "DELETE FROM Tarea WHERE nom_tarea='$nombre' AND correo_usr='$email' AND id_proyecto=$id";
        try {
            if($conn->query($sql)) {
                $val = true;
            }
        } catch(Exception $e) {
        }
        close_connection($conn);
        return $val;
    }
?>