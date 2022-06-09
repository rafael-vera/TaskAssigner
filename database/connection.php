<?php
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

    function get_projects($email) {
        $projects = array(
            'nombre'=>array(),
            'descripcion'=>array()
        );
        $conn = connection();
        $result = $conn->query(
            "SELECT proyecto.nom_proyecto, proyecto.desc_proyecto FROM proyecto, usuarioproyecto
             WHERE proyecto.id_proyecto = usuarioproyecto.id_proyecto AND usuarioproyecto.correo_usr = '$email'"
        );
        if($result->num_rows > 0) {
            while($project = $result->fetch_row()) {
                array_push($projects['nombre'], $project[0]);
                array_push($projects['descripcion'], $project[1]);
            }
        }
        close_connection($conn);
        return $projects;
    }
?>