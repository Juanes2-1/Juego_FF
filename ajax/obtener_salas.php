<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

if (isset($_GET['id_select_sala'])) {
    $id_select_sala = $_GET['id_select_sala'];
    $sqlSalas = $con->prepare("SELECT * FROM salas WHERE ID_mapas = :id_select_sala");
    $sqlSalas->bindParam(':id_select_sala', $id_select_sala, PDO::PARAM_INT);
    $sqlSalas->execute();
    $salas = $sqlSalas->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si todas las salas están llenas
    $todasLlenas = true;
    foreach ($salas as $sala) {
        if ($sala['jugadores'] < 5) {
            $todasLlenas = false;
            break;
        }
    }

    // Crear una nueva sala si todas están llenas
    if ($todasLlenas) {
        $nuevoNombreSala = "Sala " . (count($salas) + 1);
        $sqlNuevaSala = $con->prepare("INSERT INTO salas (nombre_sala, jugadores, ID_mapas) VALUES (:nombre_sala, 0, :id_select_sala)");
        $sqlNuevaSala->bindParam(':id_select_sala', $id_select_sala, PDO::PARAM_INT);
        $sqlNuevaSala->bindParam(':nombre_sala', $nuevoNombreSala, PDO::PARAM_STR);
        $sqlNuevaSala->execute();

        $sqlSalas->execute();
        $salas = $sqlSalas->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode($salas);
}
?>