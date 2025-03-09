<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();
?>

<?php
    $sqlavatars = $con->prepare("SELECT * FROM avatar");
    $sqlavatars->execute();
    $a = $sqlavatars->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/avatars.css">
</head>
<body>
    <main class="container-main-avatars" id="avatars">
        <div class="container-div-avatars">
            <h3>Seleccione el Avatar</h3>
            <div class='container-columns-avatars'>
                <?php
                    $sqlavatars = $con->prepare("SELECT * FROM avatar");
                    $sqlavatars->execute();

                    while($avatars = $sqlavatars -> fetch(PDO::FETCH_ASSOC)){
                        echo "<div class='container-img-avatars'>" .
                            "<img src='../img/avatares/" . $avatars['imagen'] . "' alt='" . $avatars['avatar'] . "' data-id='" . $avatars['ID_avatar'] . "' class='avatar-select'>" . 
                                "<div class='container-name-avatars'>" .
                                    "<p>" . $avatars['avatar'] . "</p>" .
                                "</div>" .
                            "</div>";
                    }
                ?>
            </div>
        </div>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('.avatar-select').click(function(){
            let id_avatar = $(this).data('id'); // Obtener el ID del avatar seleccionado
            let id_usuario = <?php echo $_SESSION['id_usuario']; ?>;
            actualizarAvatar(id_avatar, id_usuario);
        });
    });

    function actualizarAvatar(id_avatar, id_usuario){
        $.ajax({
            type: "GET",
            url: "../ajax/avatar_select.php",
            data: { id_avatar: id_avatar, id_usuario: id_usuario },
            success: function(response){
                $('#container-select-avatars').html(response);
            }
        });
    }
</script>
</html>