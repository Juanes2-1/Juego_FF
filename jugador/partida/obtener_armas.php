<?php
// iniciamos la sesion para poder usar las variables de sesion
session_start();

// conectamos a la base de datos
require_once('../../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// obtiene el nivel del jugador
$sql = $con->prepare("SELECT nivel FROM usuario WHERE ID_usuario = ?");
$sql->execute([$_SESSION['id_usuario']]);
$nivel = $sql->fetch(PDO::FETCH_ASSOC)['nivel'];

// obtiene las armas que puede usar segun su nivel
$sql = $con->prepare("SELECT * FROM armas WHERE nivel_ar <= ?");
$sql->execute([$nivel]);
$armas = $sql->fetchAll(PDO::FETCH_ASSOC);

// organiza las armas por tipo
$armasPorTipo = [];
foreach($armas as $arma) {
    if(!isset($armasPorTipo[$arma['ID_tipo']])) {
        $armasPorTipo[$arma['ID_tipo']] = [];
    }
    $armasPorTipo[$arma['ID_tipo']][] = $arma;
}

// nombres de cada tipo de arma
$tiposArma = [
    1 => "cuerpo a cuerpo",
    2 => "pistolas",
    3 => "francotirador",
    4 => "subfusiles"
];

// incluimos el archivo de estilos
echo '<link rel="stylesheet" href="../../styles/styles_jugador/armas.css">';

// muestra la ventana de seleccion
echo "<div class='armas-container'>";
echo "<div class='armas-header'>";
echo "<h2>selecciona un arma</h2>";
echo "<button onclick='cerrarVentana()' class='btn-cerrar'>x</button>";
echo "</div>";

// muestra las armas por seccion
foreach($armasPorTipo as $tipoId => $armasDelTipo) {
    echo "<div class='seccion-armas'>";
    echo "<h3>" . $tiposArma[$tipoId] . "</h3>";
    echo "<div class='armas-grid'>";
    
    foreach($armasDelTipo as $arma) {
        // revisa si el jugador puede usar el arma
        $bloqueada = ($arma['nivel_ar'] > $nivel) ? 'bloqueada' : '';
        
        echo "<div class='arma-card $bloqueada'>";
        echo "<img src='../../img/armas/{$arma['imagen_armas']}' alt='{$arma['nombre']}'>";
        echo "<h4>{$arma['nombre']}</h4>";
        echo "<p>dano: {$arma['danio']}</p>";
        
        if (!$bloqueada) {
            $dano = intval($arma['danio']);
            echo "<button class='arma-opcion' 
                          data-arma-id='{$arma['ID_arma']}' 
                          data-dano='{$dano}'>";
            echo "seleccionar";
            echo "</button>";
        } else {
            echo "<p class='nivel-requerido'>nivel {$arma['nivel_ar']} requerido</p>";
        }
        
        echo "</div>";
    }
    echo "</div></div>";
}

echo "</div>";
echo "<div class='armas-footer'>";
echo "<button onclick='cerrarVentana()' class='btn-cancelar'>cancelar</button>";
echo "</div>";
?> 