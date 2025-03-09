<?php
    session_start();
    require_once('../conex/conex.php');
	// include 'mapas.php';
    $conex = new Database;
    $con = $conex->conectar();
?>

<?php
    if (isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
        $sql = $con -> prepare("SELECT * FROM usuario INNER JOIN roles ON usuario.ID_rol = roles.ID_rol
        INNER JOIN estado ON usuario.ID_estado = estado.ID_estado INNER JOIN avatar ON usuario.ID_avatar = avatar.ID_avatar WHERE usuario.ID_usuario = '$id_usuario'");
        $sql -> execute();
        $u = $sql -> fetch();
    }
    else {
        echo '<script>alert("Debes iniciar sesión para acceder a esta página")</script>';
        echo '<script>window.location = "../index.html"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/inicio.css">
    <title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="container-header">
		<div class="container-info-user">
			<label for="user" class="user"><?php echo $u['username'] ?></label>
		</div>
        
		<div class='container-sesion'>
            <form action="../include/logout.php" method="POST">
                <button type="submit">CERRAR SESIÓN</button>
            </form>
        </div>
    </header>

	<main class='container-main'>
		<div class='container-content'>
			<div class='container-menu'>
				<a href="avatars.php"><i class="bi bi-bag-fill"></i> AVATAR</a>
			</div>

			<div class='container-avatares'>
				<img src="../img/avatares/<?php echo $u['imagen'] ?>" alt="">
			</div>

			<div class='container-select'>
                <select name="select-mapas" class='select-mapas' id="select-mapas">
                    <option value="">SELECCIONAR MAPA:</option>
                    <?php
                        $sqlMapas = $con->prepare("SELECT * FROM mapas");
                        $sqlMapas->execute();
                        
                        while ($mapas = $sqlMapas->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $mapas['ID_mapas'] . "'>" . $mapas['mapas'] . "</option>";
                        }
                    ?>
                </select>
                <div name="container-button" class='container-button' id="container-button">
                    
                </div>
                
            </div>
			
		</div>
	</main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#select-mapas').val(0);
        recargarLista();

        $('#select-mapas').change(function(){
            recargarLista();
        });

        setInterval(recargarLista, 1000);
    });
    
    function recargarLista(){
        $.ajax({
            type: "GET",
            url: "mapas.php",
            data: { 'select-mapas': $('#select-mapas').val() },
            success: function(r){
                $('#container-button').html(r);
            }
        });
    }
</script>

</html>