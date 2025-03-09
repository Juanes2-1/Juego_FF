<?php
session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$atacante_id = $_SESSION['id_usuario'];
$objetivo_id = $_POST['objetivo_id'];
$dano = intval($_POST['dano']);
$id_sala = $_POST['id_sala'];
$esHeadshot = $_POST['es_headshot'] == 1;

// Si es headshot, duplica el daño
if ($esHeadshot) {
    $dano *= 2;
    // Incrementar contador de headshots en la tabla partidas
    $sql = $con->prepare("UPDATE partidas SET headshots = headshots + 1 WHERE ID_sala = ? AND ID_usuario = ?");
    $sql->execute([$id_sala, $atacante_id]);
}

// Obtener y actualizar vida del objetivo
$sql = $con->prepare("SELECT vida FROM usuario WHERE ID_usuario = ?");
$sql->execute([$objetivo_id]);
$vida_actual = $sql->fetch(PDO::FETCH_ASSOC)['vida'];
$vida_restante = max(0, $vida_actual - $dano);

// Actualizar vida del objetivo
$sql = $con->prepare("UPDATE usuario SET vida = ? WHERE ID_usuario = ?");
$sql->execute([$vida_restante, $objetivo_id]);

// Actualizar puntos del atacante (100 si mata, o el valor del daño si no) es decir, si el objetivo muere, gana 100 puntos, si no, gana el daño causado
$puntos = ($vida_restante <= 0) ? 100 : $dano;
$sql = $con->prepare("UPDATE usuario SET Puntos = Puntos + ? WHERE ID_usuario = ?");
$sql->execute([$puntos, $atacante_id]);

// Actualizar estadísticas de la partida
$sql = $con->prepare("UPDATE partidas 
                     SET dano_total = COALESCE(dano_total, 0) + ?,
                         puntos_partida = COALESCE(puntos_partida, 0) + ?
                     WHERE ID_sala = ? AND ID_usuario = ?");
$sql->execute([$dano, $puntos, $id_sala, $atacante_id]);

// Devolver respuesta
echo json_encode([
    'success' => true,
    'dano_causado' => $dano,
    'vida_restante' => $vida_restante,
    'puntos_ganados' => $puntos,
    'esHeadshot' => $esHeadshot
]);
?>