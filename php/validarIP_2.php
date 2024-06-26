<?php

    $IpAutorizada = array (//"10.63.25.*",
" ::1");
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if (in_array($ip,$IpAutorizada)){
        // Si la ip en el array solo dara acceso al sistema
         $ip = 1;
    }
    else{
        // Si la ip no esta en la lista manda error
      $ip=0;
       
    }


?> 
