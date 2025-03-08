<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$sala_id = $_POST['sala_id'];
$ganador_id = $_POST['ganador_id'];

try {
    // actualizamos al ganador
    $sql = $con->prepare("UPDATE usuario u 
                         SET u.partidas_ganadas = u.partidas_ganadas + 1
                         WHERE u.ID_usuario = ?");
    $sql->execute([$ganador_id]);

    // actualizamos a los perdedores 
    $sql = $con->prepare("UPDATE usuario u 
                         INNER JOIN partidas p ON u.ID_usuario = p.ID_usuario 
                         SET u.partidas_perdidas = u.partidas_perdidas + 1
                         WHERE p.ID_sala = ? 
                         AND p.ID_usuario != ?");
    $sql->execute([$sala_id, $ganador_id]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>