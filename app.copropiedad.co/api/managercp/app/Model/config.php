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
define('__DBHOST', 'mongo-in.copropiedad.co');
define('__DBPORT', 27017);
define('__DBUSERNAME', 'copropiedad');
define('__DBPASSWORD', 't3l31nt32015');
define('__REGISTERLIMIT', 1000);
////// definicion de rutas de logs
define('__LOGSROUTE', 'C:\xampp\htdocs\tareas\app\Model\Logs\\');
define('__DEBUG', false);
define('__MODULOS', '4,Eventos|5,Encuestas|6,Cartelera|7,Parqueaderos|8,Reservas|9,Votaciones|10,Solicitudes|11,Encomiendas|12,Documentos|13,Contabilidad');
?>