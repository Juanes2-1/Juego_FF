<?php
// iniciamos la sesion para poder usar las variables de sesion
session_start();

// conectamos a la base de datos
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// obtenemos la vida del jugador que nos piden
$sql = $con->prepare("SELECT vida FROM usuario WHERE ID_usuario = ?");
$sql->execute([$_GET['usuario_id']]);
$vida = $sql->fetch(PDO::FETCH_ASSOC);

// devolvemos la vida en formato json para que javascript lo entienda
echo json_encode($vida);
?> 