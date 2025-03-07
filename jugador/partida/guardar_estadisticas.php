<?php
require_once('../../conex/conex.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    exit;
}

$conex = new Database;
$con = $conex->conectar();

$usuario_id = $_SESSION['usuario_id'];
$tipo = $_POST['tipo'];

switch($tipo) {
    case 'victoria':
        $sql = $con->prepare("UPDATE usuario SET partidas_ganadas = partidas_ganadas + 1 WHERE ID_usuario = ?");
        $sql->execute([$usuario_id]);
        break;
    case 'derrota':
        $sql = $con->prepare("UPDATE usuario SET partidas_perdidas = partidas_perdidas + 1 WHERE ID_usuario = ?");
        $sql->execute([$usuario_id]);
        break;
    case 'headshot':
        $sql = $con->prepare("UPDATE usuario SET headshots = headshots + 1 WHERE ID_usuario = ?");
        $sql->execute([$usuario_id]);
        break;
    case 'dano':
        $dano = $_POST['dano'];
        $sql = $con->prepare("UPDATE usuario SET dano_total = dano_total + ? WHERE ID_usuario = ?");
        $sql->execute([$dano, $usuario_id]);
        break;
}

echo json_encode(['success' => true]); 