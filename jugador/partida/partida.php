<?php
    session_start();
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$ruta_avatares = "../../img/avatares/";

    if (isset($_GET['id_sala'])) {
        $id_usuario = $_SESSION['id_usuario'];
        $id_sala = $_GET['id_sala'];

$sql = $con->prepare("SELECT usuario.ID_usuario, usuario.username, usuario.vida, avatar.imagen 
          FROM usuario 
          INNER JOIN partidas ON usuario.ID_usuario = partidas.ID_usuario 
          INNER JOIN avatar ON usuario.ID_avatar = avatar.ID_avatar 
          WHERE partidas.ID_sala = ?");
        $sql->execute([$id_sala]);
$jugadores = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $con->prepare("SELECT username, vida, Puntos, avatar.imagen
                FROM usuario 
                INNER JOIN avatar ON usuario.ID_avatar = avatar.ID_avatar
                WHERE ID_usuario = ?");
        $sql->execute([$id_usuario]);
$jugadorActual = $sql->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida en Curso</title>
    <link rel="stylesheet" href="../../styles/styles_jugador/partida.css">
    <link rel="stylesheet" href="../../styles/styles_jugador/estadisticas.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Partida en Curso</h1>
        </header>

        <main>
            <!-- mostrar jugador actual -->
            <div class="jugador-actual">
                <h2>Username: <?php echo $jugadorActual['username']; ?></h2>
                <div class="stats">
                    <!--primero concatenamos la ruta y luego le decimos cual es el nombre del avatar q tiene el player y se le cambia el tamaño-->
                    <img src="<?php echo $ruta_avatares . $jugadorActual['imagen']; ?>" alt="Avatar" style="width: 150px; height: 220px;">
                    <div class="vida-barra">
                        <div class="vida-actual" style="width: <?php echo ($jugadorActual['vida']/100)*100; ?>%">
                            <?php echo $jugadorActual['vida']; ?>/100
                        </div>
                    </div>
                    <p>Puntos: <?php echo $jugadorActual['Puntos']; ?></p>
                </div>
            </div>

            <!-- grid de jugadores -->
            <div class="jugadores-grid">
                <?php foreach($jugadores as $jugador): ?>
                    <?php if($jugador['ID_usuario'] != $id_usuario): ?>
                        <div class="jugador-card" data-id="<?php echo $jugador['ID_usuario']; ?>">
                            <img src="<?php echo $ruta_avatares . $jugador['imagen']; ?>" alt="Avatar">
                            <h3><?php echo $jugador['username']; ?></h3>
                            <div class="vida-barra">
                                <div class="vida-actual" style="width: <?php echo ($jugador['vida']/100)*100; ?>%">
                                    <?php echo $jugador['vida']; ?>/100
                                </div>
                            </div>
                            <button onclick="seleccionarObjetivo(<?php echo $jugador['ID_usuario']; ?>)" 
                                    class="btn-atacar">Atacar</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </main>

        <footer>
            <button onclick="location.href='index.php'" class="btn-abandonar">Abandonar Partida</button>
        </footer>
    </div>

    <!-- Modal para seleccionar arma -->
    <div id="modal-armas" class="modal">
        <div class="modal-content">
            <h2>Selecciona un arma</h2>
            <div id="lista-armas"></div>
            <button onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <!-- Agregar antes del cierre del body -->
    <div id="modal-estadisticas" class="modal">
        <div class="modal-content">
            <h2>Resumen de partida</h2>
            <div class="estadisticas">
                <p id="puntos-totales">Puntos totales: 0</p>
                <p id="eliminaciones">Eliminaciones: 0</p>
                <p id="daño-total">Daño total: 0</p>
            </div>
            <button onclick="location.href='index.php'" class="btn-salir">Volver al lobby</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // variables globales para el manejo de la partida
        const USUARIO_ACTUAL_ID = <?php echo $id_usuario; ?>;
        const SALA_ACTUAL_ID = <?php echo $id_sala; ?>;
        
        let objetivoSeleccionado = null;

        // funcion que guarda el id del jugador seleccionado para atacar y abre el modal de armas
        function seleccionarObjetivo(usuarioId) {
            objetivoSeleccionado = usuarioId;
            cargarArmas();
        }

        // funcion que hace una peticion ajax para obtener las armas disponibles y mostrarlas en el modal
        function cargarArmas() {
            $.ajax({
                url: 'obtener_armas.php',
                method: 'GET',
                data: { sala_id: SALA_ACTUAL_ID },
                success: function(r) {
                        $('#lista-armas').html(r);
                    $('#modal-armas').show();
                }
            });
        }

        // funcion que procesa el ataque enviando los datos necesarios al servidor
        function atacar(armaId) {
            if (!objetivoSeleccionado) {
                console.log('No hay objetivo seleccionado');
                return;
            }
            
            console.log('Enviando ataque:', {
                atacante_id: USUARIO_ACTUAL_ID,
                objetivo_id: objetivoSeleccionado,
                arma_id: armaId,
                sala_id: SALA_ACTUAL_ID
            });
            
            $.ajax({
                url: 'procesar_ataque.php',
                method: 'POST',
                data: {
                    atacante_id: USUARIO_ACTUAL_ID,
                    objetivo_id: objetivoSeleccionado,
                    arma_id: armaId,
                    sala_id: SALA_ACTUAL_ID
                },
                success: function(r) {
                    console.log('Respuesta del ataque:', r);
                    cerrarModal();
                    actualizarVidas();
                    actualizarPuntos();
                },
                error: function(xhr, status, error) {
                    console.error('Error en el ataque:', error);
                    console.log('Respuesta completa:', xhr.responseText);
                }
            });
        }

        // funcion que oculta el modal de armas y reinicia el objetivo seleccionado
        function cerrarModal() {
            $('#modal-armas').hide();
            objetivoSeleccionado = null;
        }

        // funcion que actualiza la barra de vida del jugador actual mediante ajax
        function actualizarJugadorActual() {
            $.ajax({
                url: 'obtener_vida_actual.php',
                method: 'GET',
                data: { usuario_id: USUARIO_ACTUAL_ID },
                success: function(r) {
                    const datos = JSON.parse(r);
                    // calcula el porcentaje de vida para la barra de vida del jjugador
                    const porcentaje = (datos.vida / 100) * 100;
                    $('.jugador-actual .vida-actual')
                        .css('width', `${porcentaje}%`)
                        .text(`${datos.vida}/100`);
                    
                    // Si el jugador muere, guardar estadísticas antes de mostrarlas
                    if (datos.vida <= 0) {
                                guardarEstadisticasPartida();
                    }
                }
            });
        }

        // Agregar esta nueva función
        function guardarEstadisticasPartida() {
            $.ajax({
                url: 'guardar_estadisticas.php',
                method: 'POST',
                data: { 
                    usuario_id: USUARIO_ACTUAL_ID,
                    sala_id: SALA_ACTUAL_ID
                },
                success: function(r) {
                    console.log('Estadísticas guardadas:', r);
                            mostrarEstadisticasFinales();
                },
                error: function(error) {
                    console.error('Error al guardar estadísticas:', error);
                }
            });
        }

        // funcion que actualiza las barras de vida de los demas jugadores
        function actualizarOtrosJugadores() {
            $.ajax({
                url: 'obtener_vidas.php',
                data: { sala_id: SALA_ACTUAL_ID },
                method: 'GET',
                success: function(r) {
                    const vidas = JSON.parse(r);
                    // itera sobre cada jugador y actualiza su barra de vida si no es el jugador actual
                    vidas.forEach(jugador => {
                        if (jugador.ID_usuario != USUARIO_ACTUAL_ID) {
                            const porcentaje = (jugador.vida / 100) * 100;
                            // usa el selector data-id para encontrar la carta del jugador correcta
                            $(`.jugador-card[data-id="${jugador.ID_usuario}"] .vida-actual`)
                                .css('width', `${porcentaje}%`)
                                .text(`${jugador.vida}/100`);
                        }
                    });
                }
            });
        }

        // funcion que actualiza los puntos del jugador actual en la interfaz
        function actualizarPuntos() {
            $.ajax({
                url: 'obtener_puntos.php',
                method: 'GET',
                data: { usuario_id: USUARIO_ACTUAL_ID },
                success: function(r) {
                    console.log('Respuesta puntos:', r); // Debug
                    const datos = JSON.parse(r);
                    if (datos && datos.Puntos !== undefined) {
                        // Actualiza el texto de puntos en la interfaz
                        $('.jugador-actual .stats p').text(`Puntos: ${datos.Puntos}`);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar puntos:', error);
                }
            });
        }

        // Agregar función para mostrar estadísticas
        function mostrarEstadisticasFinales() {
            $.ajax({
                url: 'obtener_estadisticas.php',
                method: 'GET',
                data: { usuario_id: USUARIO_ACTUAL_ID },
                success: function(r) {
                        const stats = JSON.parse(r);
                    
                    // Mostrar estadísticas
                    $('#puntos-totales').text(`Puntos en esta partida: ${stats.puntos_partida}`);
                    $('#eliminaciones').text(`Eliminaciones: ${stats.eliminaciones_totales}`);
                    $('#daño-total').text(`Daño total: ${stats.dano_total}`);
                    
                        $('#modal-estadisticas').show();
                },
                error: function(error) {
                    console.error('Error al obtener estadísticas:', error);
                }
            });
        }

        // Actualizar puntos al cargar la página
        actualizarPuntos();

        // intervalos que actualizan la informacion cada 2 segundos
        setInterval(actualizarJugadorActual, 2000);
        setInterval(actualizarOtrosJugadores, 2000);
        setInterval(actualizarPuntos, 2000);

        function finalizarPartida() {
            fetch('finalizar_partida.php')
            .then(response => response.json())
            .then(data => {
                // si es_ganador es true, muestra mensaje de victoria
                if (data.ganador) {
                    mostrarMensaje('¡Victoria!');
                    reproducirSonidoVictoria();
                    // mostrar efectos de victoria
                } else {
                    mostrarMensaje('Derrota');
                    reproducirSonidoDerrota();
                    // mostrar efectos de derrota
                }
                
                // el resto del codigo del modal...
            });
        }

        function volverAlLobby() {
            window.location.href = '../sala/lobby.php';
        }

        function nuevaPartida() {
            // Verificar si hay suficientes jugadores en la sala
            fetch('verificar_jugadores_sala.php')
            .then(response => response.json())
            .then(data => {
                if (data.suficientes_jugadores) {
                    window.location.reload();
                } else {
                    mostrarMensaje('No hay suficientes jugadores para iniciar una nueva partida');
                }
            });
        }

        function desactivarControlesJuego() {
            // Desactivar botones de ataque
            const botonesAtaque = document.querySelectorAll('.btn-ataque');
            botonesAtaque.forEach(boton => {
                boton.disabled = true;
            });
            
            // Desactivar seleccion de armas
            const selectArmas = document.querySelector('#seleccion-arma');
            if (selectArmas) {
                selectArmas.disabled = true;
            }
        }

        function mostrarMensaje(mensaje, tipo = 'info') {
            const divMensaje = document.createElement('div');
            divMensaje.className = `mensaje ${tipo}`;
            divMensaje.textContent = mensaje;
            
            document.body.appendChild(divMensaje);
            
            setTimeout(() => {
                divMensaje.remove();
            }, 3000);
        }
    </script>
</body>
</html>
