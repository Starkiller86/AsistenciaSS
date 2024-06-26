<?php
	if(isset($_POST)) {
		require "../db/connectDB.php";
		$usuario = mysqli_real_escape_string($conn, $_POST["user"]);
		$password = mysqli_real_escape_string($conn, $_POST["pass"]);
		//$hora = $_POST['reloj'];
		$hora = date("H:i:s");
		$fecha= date("Y-m-d");
		$query="SELECT * FROM alumno_password WHERE id_alumno='$usuario' AND password='$password'";
		$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
		if(mysqli_num_rows($result)>0) {
			$query="SELECT status FROM alumno WHERE id_alumno='$usuario'";
			$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
			$row=mysqli_fetch_array($result);
			if ($row['status']=="Activo") {
				$query="SELECT status FROM alumno_servicio WHERE id_alumno=$usuario";
				$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
				if(mysqli_num_rows($result)>0) {
					$proyecto=mysqli_fetch_array($result);
					if($proyecto['status']=="Activo") {
						$query="SELECT id_alumno FROM horario WHERE id_alumno=$usuario AND status='Activo'";
						$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
						if(mysqli_num_rows($result)>0) {
							$dia=date("w");
							$query="SELECT e$dia, s$dia FROM horario WHERE id_alumno=$usuario AND e$dia IS NOT NULL AND s$dia IS NOT NULL";
							$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
							if(mysqli_num_rows($result)>0) {
								$horario=mysqli_fetch_array($result);
								$query="SELECT * FROM asistencia WHERE fecha='$fecha' AND status='Salida no registrada' AND id_alumno=$usuario";
								$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
								if(mysqli_num_rows($result)>0) {
									if(strtotime($hora)>(strtotime($horario["s$dia"]))) {
										$hora=$horario["s$dia"];
									}
									$query="SELECT tipo_horas FROM alumno_servicio WHERE id_alumno=$usuario";
									$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									$tipo=mysqli_fetch_array($result);
									$query="UPDATE asistencia SET hora_salida='$hora', status='Salida registrada' WHERE status='Salida no registrada' AND fecha='$fecha' AND id_alumno=$usuario";
									$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									$query="SELECT hora_entrada FROM asistencia WHERE hora_salida='$hora' AND status='Salida registrada' AND fecha='$fecha' AND id_alumno=$usuario";
									$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									$horas=mysqli_fetch_array($result);
									$query="SELECT TIMEDIFF('$hora', '$horas[hora_entrada]')";
									$result = mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									$horas_real = mysqli_fetch_array($result);
									$query="SELECT SEC_TO_TIME( TIME_TO_SEC( '$horas_real[0]' ) * $tipo[0] ) FROM dual";
									$result = mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									$horas_totales=mysqli_fetch_array($result);
									$query="UPDATE asistencia SET horas_reales='$horas_totales[0]', horas='$horas_real[0]' WHERE fecha='$fecha' AND status='Salida registrada' AND id_alumno=$usuario AND hora_salida='$hora' AND hora_entrada='$horas[hora_entrada]'";
									$result = mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
									mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
									header("Location:../index.php?a=A0002&id=$usuario");	
								}
								else {
									if(strtotime($hora)>=(strtotime($horario["e$dia"])-900)) {
										if(strtotime($hora)<strtotime($horario["s$dia"])) {
											$query="SELECT fecha FROM asistencia WHERE fecha='$fecha' AND id_alumno=$usuario";
											$result = mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
											if(mysqli_num_rows($result)==0) {
												if(strtotime($hora)>strtotime($horario["e$dia"])+59) {
													$query="INSERT INTO asistencia VALUES ('$usuario','$fecha','$hora','00:00:00','Salida no registrada', '00:00:00', '00:00:00', 'R')";
												}
												else {
													$query="INSERT INTO asistencia VALUES ('$usuario','$fecha','$hora','00:00:00','Salida no registrada', '00:00:00', '00:00:00', '')";
												}
												$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
												mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
												header("Location:../index.php?a=A0001");
											}
											else {
												$query="INSERT INTO asistencia VALUES ('$usuario','$fecha','$hora','00:00:00','Salida no registrada', '00:00:00', '00:00:00', '')";
												$result=mysqli_query($conn, $query) or header("Location:../index.php?emysql=".mysqli_error($conn));
												mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
												header("Location:../index.php?a=A0001");
											}
										}
										else {
											mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
											header("Location:../index.php?e=E0009");
										}
									}
									else {
										mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
										header("Location:../index.php?e=E0008");
									}
								}	
							}
							else {
								mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
								header("Location:../index.php?e=E0007");
							}
						}
						else {
							mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
							header("Location:../index.php?e=E0006");
						}
					}
					else {
						if($proyecto['status']=="Inactivo") {
							mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
							header("Location:../index.php?e=E0010");
						}
						else {
							if($proyecto['status']=="Terminado") {
								mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
								header("Location:../index.php?e=E0005");
							}
						}
					}
				}
				else {
					mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
					header("Location:../index.php?e=E0004");
				}
			}
			else {
				if ($row['status']=="Inactivo") {
					mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
					header("Location:../index.php?e=E0002");
				}
				else {
					if ($row['status']=="Terminado") {
						mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
						header("Location:../index.php?e=E0003");
					}
				}
			}
		}
		else {
			mysqli_close($conn) or header("Location:../index.php?emysql=".mysqli_error($conn));
			header("Location:../index.php?e=E0001");
		}
	}
	else {
		header("Location:../index.php");
	}
?>
