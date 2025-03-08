<?php
// iniciamos la sesion para poder usar las variables de sesion
session_start();

// conectamos a la base de datos
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// datos basicos del ataque
$atacante_id = $_SESSION['id_usuario'];
$objetivo_id = $_POST['objetivo_id'];
$dano = intval($_POST['dano']); // aseguramos que sea número
$id_sala = $_POST['id_sala'];

try {
    $con->beginTransaction();

    // obtiene y actualiza la vida del objetivo
    $sql = $con->prepare("SELECT vida FROM usuario WHERE ID_usuario = ?");
    $sql->execute([$objetivo_id]);
    $vida_actual = $sql->fetch(PDO::FETCH_ASSOC)['vida'];
    $vida_restante = max(0, $vida_actual - $dano);

    // guarda la nueva vida
    $sql = $con->prepare("UPDATE usuario SET vida = ? WHERE ID_usuario = ?");
    $sql->execute([$vida_restante, $objetivo_id]);

    // da puntos al atacante (100 si mata, o el valor del dano si no)
    $puntos = ($vida_restante <= 0) ? 100 : $dano;
    $sql = $con->prepare("UPDATE usuario SET Puntos = Puntos + ? WHERE ID_usuario = ?");
    $sql->execute([$puntos, $atacante_id]);

    // Actualizar estadisticas de la partida
    $sql = $con->prepare("UPDATE partidas 
                     SET dano_total = COALESCE(dano_total, 0) + ?,
                         puntos_partida = COALESCE(puntos_partida, 0) + ?
                     WHERE ID_sala = ? AND ID_usuario = ?");
    $sql->execute([
        $dano,
        $puntos,
        $id_sala,
        $atacante_id
    ]);

    // Actualizar puntos totales del usuario
    $sql = $con->prepare("UPDATE usuario 
                         SET Puntos = Puntos + ? 
                         WHERE ID_usuario = ?");
    $sql->execute([$puntos, $atacante_id]);

    $con->commit();

    echo json_encode([
        'success' => true,
        'dano_causado' => $dano,
        'vida_restante' => $vida_restante,
        'puntos_ganados' => $puntos
    ]);

} catch (Exception $e) {
    $con->rollBack();
    echo json_encode(['error' => $e->getMessage()]);
}
?>