<?php
require_once('class.ezpdf.php');
require '../db/connectDB.php';
$pdf = new Cezpdf('A4');
$pdf->selectFont('../fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
header('Content-Type: text/html; charset=utf-8');


$queEmp = "SELECT fecha, hora_entrada, hora_salida, horas, horas_reales, retardo FROM asistencia WHERE id_alumno=$_GET[id] AND fecha='".date("Y-n-j")."'";
$resEmp = mysqli_query($conn, $queEmp) or die(mysqli_error());
$query = "SELECT nombre, apellido_paterno, apellido_materno FROM alumno WHERE id_alumno=$_GET[id]";

$result = mysqli_query($conn, $query) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);
$nombre = $row['nombre']." ".$row['apellido_paterno']." ".$row['apellido_materno'];
$nombre = utf8_decode($nombre);
$query="SELECT SUM(HOUR(horas)) AS hora, SUM(MINUTE(horas)) AS minutos FROM asistencia WHERE fecha='".date("Y-n-j")."' AND id_alumno=$_GET[id]";
$res=mysqli_query($conn, $query) or die(mysqli_error());
$row=mysqli_fetch_array($res);
$horasx = $row["hora"];
$min = $row["minutos"];
$minutosx = $min%60;
$h=(int)($min/60);
$horasx+=$h;
$horas_hoy = utf8_decode("Horas realizadas en el día:"); 
$horas_hoy .= "<b>$horasx h $minutosx m</b>\n\n";

$query="SELECT SUM(HOUR(horas)) AS hora, SUM(MINUTE(horas)) AS minutos FROM asistencia WHERE id_alumno=$_GET[id]";
$res=mysqli_query($conn, $query) or die(mysqli_error());
$row=mysqli_fetch_array($res);
$horasx = $row["hora"];
$min = $row["minutos"];
$minutosx = $min%60;
$h=(int)($min/60);
$horasx+=$h;
$horas_acumuladas = "Total de horas acumuladas: <b>$horasx h $minutosx m</b>\n\n";

$ixx = 0;
while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}
$titles = array(
				'fecha'=>'<b>Fecha</b>',
				'hora_entrada'=>'<b>Entrada</b>',
				'hora_salida'=>'<b>Salida</b>',
				'horas'=>'<b>Horas realizadas</b>',
				'horas_reales'=>'<b>Horas reales</b>',
				'retardo'=>'<b>Retardos</b>'
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
$pdf->ezImage('../images/logo111.jpg', 50, 200, 'none', 'right');
$pdf->ezText("<b>REPORTE DE ASISTENCIA</b>\n\n", 12);
$pdf->ezText("$nombre\n\n", 12);
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("$horas_hoy", 10,array('justification'=>'center'));
$pdf->ezText("$horas_acumuladas", 10,array('justification'=>'center'));
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,array('justification'=>'right'));
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10,array('justification'=>'right'));
ob_end_clean();
$pdf->ezStream();
?>
