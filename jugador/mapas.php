<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    if (isset($_GET['select-mapas'])) {
        $id_mapas = $_GET['select-mapas'];
        $sqlMapas = $con->prepare("SELECT * FROM mapas WHERE ID_mapas = :id_mapas");
        $sqlMapas->bindParam(':id_mapas', $id_mapas, PDO::PARAM_INT);
        $sqlMapas->execute();
        $mapas = $sqlMapas->fetch(PDO::FETCH_ASSOC);

        if ($mapas == 0) {
            echo "<a href='salas.php?id_select_sala=1' class='button-iniciar'>INICIAR</a>";
        } else {
            $sqlSala = $con->prepare("SELECT * FROM mapas WHERE ID_mapas = :id_mapas");
            $sqlSala->bindParam(':id_mapas', $id_mapas, PDO::PARAM_INT);
            $sqlSala->execute();
            $sala = $sqlSala->fetch(PDO::FETCH_ASSOC);

            echo "<a href='salas.php?id_select_sala=" . $sala['ID_mapas'] . "' class='button-iniciar'>INICIAR</a>";
        }
    }
?>