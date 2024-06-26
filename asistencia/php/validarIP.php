<?php

    $IpAutorizada = array (//"172.63.25.*",
                          "172.63.25.24", //Recepcion RCI antes 17
                          "10.63.25.55", //Ip de equipo de sandra dirección
                          "10.63.25.50", //IP de equipo de PEPe RCI 
                          "10.63.25.59", // ip EQUIPO DE mercedes-Daniel EVENTOS
                          "10.63.25.229",//PC de  Toño
                          "10.63.25.18", //Biblioteca Infantil recepcion2
                          "10.63.19.21", //Biblioteca Adultos recepción, equipo de Ale
                          "10.63.25.29", //Equipo de Abel 
                          "10.30.20.100", //VPN
                          "10.30.20.101", //VPN
                          "10.63.25.49",//rubens equipo       
                          "10.63.25.44", //Equipo Claudia 
                          "10.63.25.43", //equipo de male 
                          "10.63.81.201", //Equipo de prueba de ss
                          "10.63.25.13",// Equipo  de SS RCI 
                         "10.63.70.95", //Equipo recepcion ssRCI wifi  
                          "10.63.25.15", //Equipo de eventos
                          "10.63.25.38", 

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
