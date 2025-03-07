<?php
require_once('../../conex/conex.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    exit;
}

$conex = new Database;
$con = $conex->conectar();

$usuario_id = $_SESSION['usuario_id'];

$sql = $con->prepare("SELECT partidas_ganadas, partidas_perdidas, dano_total, headshots 
                      FROM usuario 
                      WHERE ID_usuario = ?");
$sql->execute([$usuario_id]);
$resultado = $sql->fetch(PDO::FETCH_ASSOC);

echo json_encode($resultado);