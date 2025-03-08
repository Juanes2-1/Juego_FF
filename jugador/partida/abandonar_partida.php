<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$usuario_id = $_POST['usuario_id'];
$sala_id = $_POST['sala_id'];

try {
    // elimina al jugador de la partida
    $sql = $con->prepare("DELETE FROM partidas 
                         WHERE ID_usuario = ? 
                         AND ID_sala = ?");
    $sql->execute([$usuario_id, $sala_id]);

    // resetea la vida del jugador
    $sql = $con->prepare("UPDATE usuario 
                         SET vida = 100 
                         WHERE ID_usuario = ?");
    $sql->execute([$usuario_id]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>