<?php

session_start();
unset($_SESSION['id_usuario']);
unset($_SESSION['username']);
unset($_SESSION['rol']);
unset($_SESSION['avatar']);
unset($_SESSION['estado']);
session_destroy();
session_write_close();

header("Location: ../login.html");
exit();

?>