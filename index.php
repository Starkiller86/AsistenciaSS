<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Joaquin Hernandez Quirino">

        <title>Registro De Asistencia</title> 
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">  
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

       
        <script type="text/javascript"> 
		<!-- Funcion que emplea ajax para obtener la hora del servidor -->
			function clock() { 				
				var xmlHTTP;
				if (window.XMLHttpRequest) {
					xmlHTTP=new XMLHttpRequest(); 
				} else { 
					xmlHTTP=new ActiveXObject("Microsoft.XMLHTTP"); 
				}				
				xmlHTTP.onreadystatechange=function() {
					if (xmlHTTP.readyState==4 && xmlHTTP.status==200) {						
						document.formulario.reloj.value	= xmlHTTP.responseText;					
					}
				}				
				xmlHTTP.open("GET", "get_hora.php", true); xmlHTTP.send();
				setTimeout("clock()",1000);
			} 
		</script> 
		
		     <!-- Favicon and touch icons -->
         <link rel="shortcut icon" href="images/favicon2.ico">
   
    </head>

    <body onload="clock()">
        <div class="login-box" >
            <img src="images/GM2.png" alt="" width="160" height="120">
            <br><br>
            <form method='post' action='php/assistance.php' name='formulario' class='form' onsubmit='return validar(this)' style="display: <?php if($ip == 1){ echo 'block;';} else if ($ip==0){echo 'none;';}?>">
               
                <input style=" font-weight: bold; border: 0px; font-size: 50px; text-align: center;" type='text' name='reloj' size='15' class='clock' onKeyPress='return false;'>

                <input type="text" style="color:#1d00ff; font-weight: bold;"  align="center" name="user" placeholder="Usuario">
                <br><br>
                <input type="password" style="color:#1d00ff; font-weight: bold;" name="pass" placeholder="Contrase&ntilde;a">
                <br><br><br>
                <input type="submit" name="submit" value="Iniciar">
            </form>
            
            <?php {
            
           //echo "<script type='text/javascript'> 
           //swal('Este equipo No cuenta con la autorización para realizar tu registro!. Por favor ingresa desde un dispositivo válido',' !!Consulte a su lider de proyecto!!','warning')
           //.then((value) => {
           //     window.location = ('./');
           //});  </script>";
                
            }              
     
            ?>
                

        </div>
        
        

        <!-- Javascript -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.backstretch.min.js"></script>
        <script src="js/scripts.js"></script>
        
 

    </body>

</html>


<?php
	if(isset($_GET['emysql'])) {
		$error =  str_replace("%20"," ",$_GET['emysql']);
		$error =  str_replace("'","\'",$error);
		echo "<script language='javascript' type='text/javascript'>swall('ERROR', 'MySQL Error','error')</script>";
	}
	if(isset($_GET['e'])) {
		if($_GET['e']=="E0001") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','Usuario Y/O Contraseña  incorrecto.','error')</script>";
		}
		if($_GET['e']=="E0002") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','El usuario se encuentra inactivo. Comuniquese con el administrador.', 'error')</script>";
		}
		if($_GET['e']=="E0003") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','Su sesion ha sido terminada. Comuniquese con el administrador.', 'Error')</script>";
		}
		if($_GET['e']=="E0004") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','No tiene asignado un proyecto. Comuniquese con el administrador.', 'error')</script>";
		}
		if($_GET['e']=="E0005") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','El proyecto ha sido terminado. Comuniquese con el administrador.', 'error')</script>";
		}
		if($_GET['e']=="E0006") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','No tiene asignado un horario. Comuniquese con el administrador.', 'error')</script>";
		}
		if($_GET['e']=="E0007") {
			echo "<script language='javascript' type='text/javascript'>aswal('ERROR!','No tiene asignado horario para este d&iacute;a. Comuniquese con el administrador.', 'error')</script>";
		}
		if($_GET['e']=="E0008") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','Solo puede registrar su asistencia máximo 15 minutos antes de su hora de entrada.', 'error')</script>";
		}
		if($_GET['e']=="E0009") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','Su horario del día de hoy a terminado.', 'error')</script>";
		}
		if($_GET['e']=="E0010") {
			echo "<script language='javascript' type='text/javascript'>swal('ERROR!','El proyecto al cual esta asignado se encuentra inactivo. Comuniquese con el administrador.', 'error')</script>";
		}
	}
	if(isset($_GET['a'])) {
		if($_GET['a']=="A0001") {
			echo "<script language='javascript' type='text/javascript'>swal('GRACIAS!','Se ha registrado correctamente su entrada.', 'success')</script>";
		}
		//if($_GET['a']=="A0002"&&isset($_GET['id'])) {
			//echo "<script language='javascript' type='text/javascript'>swal('','success')</script>";
			//echo "<script type='text/javascript'> confirm('Se ha registrado correctamente su salida. ¿Desea ver el reporte de asistencia?', 'Atención', function(r) { if( r ) window.open('php/report.php?id=$_GET[id]', '_blank', 'height=800, width=600, menubar=no, resizable=no, status=no, scrollbars=no, titlebar=no, toolbar=no') }); </script>";
		//}
        if($_GET['a']=="A0002"&&isset($_GET['id'])){
			echo "<script type='text/javascript'> 
              swal({
              title: 'GRACIAS',
              text: 'Se ha registrado correctamente su salida. ¿Desea ver el reporte de asistencia?',
              icon: 'success',
              buttons: true,
              dangerMode: true,}) .then((willDelete) => {
                  if (willDelete){
                   window.open('php/report.php?id=$_GET[id]', '_blank', 'height=700, width=700, menubar=no, resizable=no, status=no, scrollbars=no, titlebar=no, toolbar=no'
                   );
                  } else {
                    swal('Error AL Obtener El Reporte, Contacte Al Administrador!');
                  }
                });  </script>";
        }
	}
?>
