<?php
// iniciamos la sesion para poder usar las variables de sesion
session_start();

// conectamos a la base de datos
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// obtenemos la vida de todos los jugadores en la sala
$sql = $con->prepare("SELECT usuario.ID_usuario, usuario.vida, usuario.username 
                      FROM usuario 
                      INNER JOIN partidas ON usuario.ID_usuario = partidas.ID_usuario 
                      WHERE partidas.ID_sala = ?");
$sql->execute([$_GET['sala_id']]);
$vidas = $sql->fetchAll(PDO::FETCH_ASSOC);

// devolvemos las vidas en formato json para que javascript lo entienda
echo json_encode($vidas);
?> 