<?php
///////////////////// Archivo de configuraciones para los sistemas
////// Definicion de zona horaria
//definir la zona horaria
date_default_timezone_set('America/Bogota');
///// definiciones del token
///// Token Key
define('__KEY', 'J4!r06¡l');
define('__TIMELIVETOKEN', '+24 Hour');
////// definicio de la base de datos
define('__DBNAME', 'copropiedad');
define('__DBHOST', 'Localhost');
define('__DBPORT', 27017);
define('__REGISTERLIMIT', 50);
////// definicion de rutas de logs
define('__LOGSROUTE', 'C:\xampp\htdocs\tareas\app\Model\Logs\\');
define('__DEBUG', false);
define('__MODULOS', '4,Eventos|5,Encuestas|6,Cartelera|7,Parqueaderos|8,Reservas|9,Votaciones');
?>