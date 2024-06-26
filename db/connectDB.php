<?php
	$urldb = "localhost";
	$userdb = "root";
	$passuserdb = "";
	$db = "alumnos";
	$conn = mysqli_connect($urldb, $userdb, $passuserdb) or header("Location:../index.php?emysql=".mysqli_error($conn));
	if(!mysqli_set_charset($conn, 'utf8'))
                printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($conn));
	mysqli_select_db($conn, $db) or header("Location:../index.php?emysql=".mysqli_error($conn));
?>
