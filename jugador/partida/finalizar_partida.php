<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$sala_id = $_POST['sala_id'];

try {
    // Obtener el jugador con más vida
    $sql = $con->prepare("SELECT ID_usuario, vida FROM usuario 
                          INNER JOIN partidas ON usuario.ID_usuario = partidas.ID_usuario 
                          WHERE partidas.ID_sala = ? 
                          ORDER BY vida DESC 
                          LIMIT 1");
    $sql->execute([$sala_id]);
    $ganador = $sql->fetch(PDO::FETCH_ASSOC);

    if ($ganador) {
        $ganador_id = $ganador['ID_usuario'];

        // Actualizar estadísticas del ganador
        $sql = $con->prepare("UPDATE usuario u 
                             SET u.partidas_ganadas = u.partidas_ganadas + 1
                             WHERE u.ID_usuario = ?");
        $sql->execute([$ganador_id]);

        // Actualizar estadísticas de los perdedores
        $sql = $con->prepare("UPDATE usuario u 
                             INNER JOIN partidas p ON u.ID_usuario = p.ID_usuario 
                             SET u.partidas_perdidas = u.partidas_perdidas + 1
                             WHERE p.ID_sala = ? 
                             AND p.ID_usuario != ?");
        $sql->execute([$sala_id, $ganador_id]);

        echo json_encode(['success' => true, 'ganador' => $ganador_id]);
    } else {
        echo json_encode(['error' => 'No se encontró un ganador']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>