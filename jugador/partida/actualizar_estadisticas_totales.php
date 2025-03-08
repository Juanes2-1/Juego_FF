<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

try {
    // Obtener estadísticas de la partida
    $sql = $con->prepare("SELECT puntos_partida, dano_causado, headshots 
                         FROM partidas 
                         WHERE ID_sala = ? AND ID_usuario = ?");
    $sql->execute([$_POST['sala_id'], $_SESSION['id_usuario']]);
    $stats_partida = $sql->fetch(PDO::FETCH_ASSOC);

    // Actualizar totales en la tabla usuario
    $sql = $con->prepare("UPDATE usuario 
                         SET Puntos = Puntos + ?,
                             dano_total = dano_total + ?,
                             headshots_total = headshots_total + ?
                         WHERE ID_usuario = ?");
    $sql->execute([
        $stats_partida['puntos_partida'],
        $stats_partida['dano_causado'],
        $stats_partida['headshots'],
        $_SESSION['id_usuario']
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>