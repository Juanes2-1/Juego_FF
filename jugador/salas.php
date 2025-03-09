<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    if (isset($_GET['id_select_sala'])) {
        $id_select_sala = $_GET['id_select_sala'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/salas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container-salas">
            <h3>Seleccione la sala</h3>
            <div class='container-div-salas'>
            </div>
        </div>
    </main>
</body>
<script>
    function updateSalas() {
        const xhr = new XMLHttpRequest();
        const id_select_sala = <?php echo json_encode($id_select_sala); ?>;
        xhr.open('GET', '../ajax/obtener_salas.php?id_select_sala=' + id_select_sala, true);//aqui se hace la peticion, primero se pasa el metodo, luego la url y por ultimo si es asincrono o no
        xhr.onload = function() {
            if (this.status === 200) {
                const salas = JSON.parse(this.responseText);//aqui se convierte la respuesta para poder ser leida
                let output = ''; 
                salas.forEach(function(sala) {
                    output += `
                        <div class='container-name-salas'>
                            <h4>${sala.nombre_sala}</h4>
                            <div class="container-persons">
                                <h4><i class="bi bi-person-fill"></i>${sala.jugadores}/5</h4>
                            </div>
                            <div class="container-button">
                                ${sala.jugadores < 5 ? `<a href="sala_espera.php?id_sala=${sala.ID_sala}"><button>UNIRSE</button></a>` : `<button disabled class='button-disabled'>LLENO</button>`}
                            </div>
                        </div>
                    `;
                });
                document.querySelector('.container-div-salas').innerHTML = output;
            }
        }
        xhr.onerror = function() {
            console.error('Error en la solicitud'); // Mensaje de depuración
        }
        xhr.send();
    }
    
    setInterval(updateSalas, 1000);
</script>
</html>