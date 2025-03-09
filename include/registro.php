<?php

require_once('../conex/conex.php');
$conex =new Database;
$con = $conex->conectar();
session_start();
$estado = 2;
$type_user = 2;
$avatar = 1;
$points = 0;
$level = 1;

?>

<?php 

    if (isset($_POST['registrarse'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $password_enc = password_hash($password, PASSWORD_DEFAULT);

        if ($username == "" || $email == "" || $password == "" || $type_user == "" || $estado == ""){
            echo "<script>alert('Existen datos vacios')</script>";
            echo "<script>window.location = '../index.html'</script>";
        } 
        
        else {
            $insertUsers = $con->prepare("INSERT INTO usuario (username, email, password, Puntos, ID_rol, ID_estado, ID_avatar, nivel) 
            VALUES ('$username', '$email', '$password_enc', '$points', '$type_user', '$estado', '$avatar', '$level')");
            $insertUsers->execute();
            echo '<script>alert("Usuario Registrado")</script>';
            echo '<script>window.location = "../login.html"</script>';
        }
    }

?>