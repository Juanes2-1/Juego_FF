<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    if (isset($_GET['id_sala'])) {
        $id_sala = $_GET['id_sala'];
        $id_usuario = $_SESSION['id_usuario'];
        $time_start = date('Y-m-d H:i:s');
        $time_end = '0000-00-00 00:00:00';

        // Incrementar el número de usuarios en la sala
        $sqlIncrement = $con->prepare("UPDATE salas SET jugadores = jugadores + 1 WHERE ID_sala = :id_sala AND jugadores < 5");
        $sqlIncrement->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sqlIncrement->execute();

        // Insertar datos de la tabla partidas
        $sqlInsertar = $con->prepare("INSERT INTO partidas (fecha_inicio, fecha_fin, ID_usuario, ID_sala) VALUES (:fecha_inicio, :fecha_fin, :id_usuario, :id_sala)");
        $sqlInsertar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $sqlInsertar->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sqlInsertar->bindParam('fecha_inicio', $time_start, PDO::PARAM_STR);
        $sqlInsertar->bindParam('fecha_fin', $time_end, PDO::PARAM_STR);
        $sqlInsertar->execute();

        // Verificar si la actualización fue exitosa
        if ($sqlIncrement->rowCount() > 0) {
            $sqlSala = $con->prepare("SELECT * FROM salas WHERE ID_sala = :id_sala");
            $sqlSala->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
            $sqlSala->execute();
            $sala = $sqlSala->fetch();

            $sqlPartidas = $con->prepare("SELECT * FROM partidas INNER JOIN usuario ON partidas.ID_usuario = usuario.ID_usuario 
            INNER JOIN salas ON partidas.ID_sala = salas.ID_sala WHERE salas.ID_sala = :id_sala");
            $sqlPartidas->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
            $sqlPartidas->execute();
            $sala_time = $sqlPartidas->fetchAll();
        } 

        // Decrementar el número de usuarios en la sala
        if (isset($_GET['exit'])) {
            $sqlDecrement = $con->prepare("DELETE FROM partidas WHERE ID_usuario = :id_usuario");
            $sqlDecrement->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $sqlDecrement->execute();

            $sqlIncrement = $con->prepare("UPDATE salas SET jugadores = jugadores - 1 WHERE ID_sala = :id_sala");
            $sqlIncrement->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
            $sqlIncrement->execute();
    
            echo '<script>alert("Saliste de la sala")</script>';
            echo '<script>window.location = "inicio.php"</script>';
        } 
    } 
    
    else {
        echo "ID de sala no Incorrecto.";
    } 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/salas_espera.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container-salas">
            <h3><?php echo $sala['nombre_sala']; ?></h3>
            <div class='container-div-salas'>
            </div>

            <div class='container-button'>
                <form action="" method="get">
                    <input type="hidden" name="id_sala" value="<?php echo $id_sala; ?>">
                    <button type="submit" name="exit" class="exit"><i class="bi bi-x-circle-fill"></i></button>
                </form>
            </div>

            <div id="container-contador">
                <p>Esperando a que se unan 5 jugadores...</p>
            </div>
            
        </div>
    </main>
</body>
<script>
    const id_Sala = <?php echo $id_sala; ?>;

    function updateSala() {
        fetch(`../ajax/actualizar_sala.php?id_sala=${id_Sala}`)
            .then(response => response.json())
            .then(data => {
                const elementContainerDivSalas = document.querySelector('.container-div-salas');
                elementContainerDivSalas.innerHTML = '';

                data.sala_time.forEach(partida => {
                    const div = document.createElement('div');
                    div.className = 'container-persons';
                    div.innerHTML = `<h4>${partida.username}</h4>`;
                    elementContainerDivSalas.appendChild(div);
                });

                const jugadores = data.sala.jugadores;
                if (jugadores >= 5) {
                    iniciarContador();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    setInterval(updateSala, 1000);

    function iniciarContador() {
        let tiempo = 10;
        const contadorElement = document.getElementById('container-contador');
        const intervalo = setInterval(function() {
            contadorElement.innerText = tiempo;
            if (tiempo <= 0) {
                clearInterval(intervalo);
                redirigirAPartida();
            }
            tiempo--;
        }, 1000);
    }

    function redirigirAPartida() {
        window.location.href = `partida/partida.php?id_sala=${id_Sala}`;
    }
</script>
</html>
