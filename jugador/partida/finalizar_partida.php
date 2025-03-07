<?php
require_once('../../conex/conex.php');
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['sala_id'])) {
    exit;
}

$conex = new Database;
$con = $conex->conectar();

$usuario_id = $_SESSION['usuario_id'];
$sala_id = $_SESSION['sala_id'];

// obtener datos completos de todos los jugadores
$sql = $con->prepare("SELECT 
                        usuario.ID_usuario,
                        usuario.Nombre,
                        usuario.Puntos,
                        usuario.headshots,
                        usuario.dano_total
                      FROM usuario 
                      INNER JOIN jugador_sala ON usuario.ID_usuario = jugador_sala.ID_usuario 
                      WHERE jugador_sala.ID_sala = ?");
$sql->execute([$sala_id]);
$jugadores = $sql->fetchAll(PDO::FETCH_ASSOC);

// encontrar el puntaje mas alto
$max_puntos = 0;
foreach ($jugadores as $jugador) {
    if ($jugador['Puntos'] > $max_puntos) {
        $max_puntos = $jugador['Puntos'];
    }
}

// actualizar estadisticas y preparar datos de respuesta
$puntuaciones = [];
$es_ganador = false;

foreach ($jugadores as $jugador) {
    if ($jugador['Puntos'] == $max_puntos) {
        // actualizar ganador
        $sql = $con->prepare("UPDATE usuario 
                             SET partidas_ganadas = partidas_ganadas + 1 
                             WHERE ID_usuario = ?");
        $sql->execute([$jugador['ID_usuario']]);
        
        if ($jugador['ID_usuario'] == $usuario_id) {
            $es_ganador = true;
        }
    } else {
        // actualizar perdedor
        $sql = $con->prepare("UPDATE usuario 
                             SET partidas_perdidas = partidas_perdidas + 1 
                             WHERE ID_usuario = ?");
        $sql->execute([$jugador['ID_usuario']]);
    }
    
    // preparar datos para la tabla de puntuaciones
    $puntuaciones[] = [
        'id' => $jugador['ID_usuario'],
        'nombre' => $jugador['Nombre'],
        'puntos' => $jugador['Puntos'],
        'headshots' => $jugador['headshots'],
        'dano_total' => $jugador['dano_total']
    ];
}

// obtener estadisticas actualizadas del jugador actual
$sql = $con->prepare("SELECT partidas_ganadas, partidas_perdidas, headshots, dano_total 
                      FROM usuario 
                      WHERE ID_usuario = ?");
$sql->execute([$usuario_id]);
$estadisticas = $sql->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'ganador' => $es_ganador,
    'puntos_maximos' => $max_puntos,
    'puntuaciones' => $puntuaciones,
    'estadisticas' => $estadisticas
]);