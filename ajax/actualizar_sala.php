<?php
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

    if (isset($_GET['id_sala'])) {
        $id_sala = $_GET['id_sala'];

        $sqlSala = $con->prepare("SELECT * FROM salas WHERE ID_sala = :id_sala");
        $sqlSala->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sqlSala->execute();
        $sala = $sqlSala->fetch(PDO::FETCH_ASSOC);


        $sqlPartidas = $con->prepare("SELECT usuario.username FROM partidas 
        INNER JOIN usuario ON partidas.ID_usuario = usuario.ID_usuario 
        WHERE partidas.ID_sala = :id_sala");
        $sqlPartidas->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sqlPartidas->execute();
        $sala_time = $sqlPartidas->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['sala' => $sala, 'sala_time' => $sala_time]);
    } 

    else {
        echo json_encode(['error' => 'ID de sala no proporcionado']);
    }
?>