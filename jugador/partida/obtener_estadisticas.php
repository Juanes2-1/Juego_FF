<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$usuario_id = $_GET['usuario_id'];

// obtener estadisticas del usuario
$sql = $con->prepare("SELECT Puntos, dano_total, headshots 
                     FROM usuario 
                     WHERE ID_usuario = ?");
$sql->execute([$usuario_id]);
$stats = $sql->fetch(PDO::FETCH_ASSOC);

echo json_encode($stats);// es para que el front-end pueda acceder a los datos
?>