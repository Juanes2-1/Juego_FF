<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// obtenemos los puntos de la partida actual
$sql = $con->prepare("SELECT puntos_partida 
                     FROM partidas 
                     WHERE ID_usuario = ? 
                     AND ID_sala = ?");
$sql->execute([$_GET['usuario_id'], $_GET['sala_id']]);
$puntos = $sql->fetch(PDO::FETCH_ASSOC);

echo json_encode($puntos);
?>