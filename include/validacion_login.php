<?php

require_once('../conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    if (isset($_POST['enviar'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if (empty($username) || empty($password)){
            echo "<script>alert('Existen datos vacíos')</script>";
            echo "<script>window.location = '../login.php'</script>";
            exit();
        } 
        
        else {
            $password_descr = htmlentities(addslashes($password));
            $sqlUser = $con->prepare("SELECT * FROM usuario WHERE username = '$username'");
            $sqlUser->execute();
            $u = $sqlUser->fetch();
    
            if ($u && password_verify($password_descr, $u["password"]) && ($u["ID_estado"] == 1)) {
                session_start();
                $_SESSION['id_usuario'] = $u['ID_usuario'];
                $_SESSION['username'] = $u['username'];
                $_SESSION['rol'] = $u['ID_rol'];
                $_SESSION['avatar'] = $u['ID_avatar'];
                $_SESSION['estado'] = $u['ID_estado'];

                if ($_SESSION['rol'] == 1) {
                    header("Location: ../admin/inicio.php");
                }
    
                if ($_SESSION['rol'] == 2) {
                    header("Location: ../jugador/inicio.php");
                }

                if ($_SESSION['estado'] == 2) {
                    echo "<script>alert('Usuario inactivo')</script>";
                    echo "<script>window.location = '../login.html'</script>";
                }
            } 
            
            else {
                echo '<script>alert("El usuario no existe o la contraseña es incorrecta")</script>';
                echo '<script>window.location = "../login.html"</script>';
                exit();
            }
        }
    }    
?>