<?php
// iniciamos la sesion para usar variables de sesion
session_start();
// incluimos el archivo de conexion a la base de datos
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// obtenemos el id del jugador y de la sala desde la peticion post
$usuario_id = $_POST['usuario_id'];
$sala_id = $_POST['sala_id'];

try {
    // obtenemos las estadisticas temporales de la partida actual del jugador
    $sql = $con->prepare("SELECT puntos_partida, dano_total, headshots 
                         FROM partidas 
                         WHERE ID_usuario = ? AND ID_sala = ?");
    $sql->execute([$usuario_id, $sala_id]);
    $stats = $sql->fetch(PDO::FETCH_ASSOC);

    // sumamos las estadisticas temporales a los totales permanentes del jugador
    $sql = $con->prepare("UPDATE usuario 
                         SET Puntos = Puntos + ?,
                             dano_total = dano_total + ?,
                             headshots = headshots + ?
                         WHERE ID_usuario = ?");
    
    // ejecutamos la actualizacion con los valores obtenidos
    $sql->execute([//estos valores vienen de arriba de la anterior consulta con la variable $stats
        $stats['puntos_partida'],  // puntos ganados en esta partida
        $stats['dano_total'],      // dano total causado en esta partida
        $stats['headshots'],       // headshots conseguidos en esta partida
        $usuario_id                // id del jugador a actualizar
    ]);

    // preparamos la respuesta con las estadisticas para mostrar en pantalla
    echo json_encode([
        'success' => true,
        'stats' => [
            'puntos_partida' => $stats['puntos_partida'],  // puntos de la partida
            'dano_total' => $stats['dano_total'],          // dano total causado
            'headshots' => $stats['headshots']             // headshots logrados
        ]
    ]);

} catch (Exception $e) {
    // si hay algun error, lo devolvemos en formato json
    echo json_encode(['error' => $e->getMessage()]);
}
?>