<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    if(isset($_GET['id_avatar']) && isset($_GET['id_usuario'])) {
        $img = $_GET['id_avatar'];
        $id_usuario = $_GET['id_usuario'];

        $sqlavatars = $con->prepare("SELECT * FROM avatar WHERE ID_avatar = :img");
        $sqlavatars->bindParam(':img', $img, PDO::PARAM_INT);
        $sqlavatars->execute();
        $avatars = $sqlavatars->fetchALL(PDO::FETCH_ASSOC);

        $cadena = "<div name='container-select-avatars' id='container-select-avatars'>";

        if ($avatars) {
            $avatar = $avatars[0];
            $cadena .= "<img src='../img/avatares/" . $avatar['imagen'] . " ' class='avatar-select' alt='" . $avatar['avatar'] . "'>";

            $id_avatar = $avatar['ID_avatar'];
            $sqlUpdateAvatars = $con->prepare("UPDATE usuario SET ID_avatar = :id_avatar WHERE ID_usuario = :id_usuario");
            $sqlUpdateAvatars->bindParam(':id_avatar', $id_avatar, PDO::PARAM_INT);
            $sqlUpdateAvatars->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $sqlUpdateAvatars->execute();
            
            echo '<script>alert("Avatar actualizado")</script>';
            echo '<script>window.location = "inicio.php"</script>';
        } 
        
        else {
            $cadena .= "<p> Avatar no encontrado. </p>";
        }

        $cadena .= "</div>";

        echo $cadena;
    }
?>