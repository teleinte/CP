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
define('__LOGSROUTE', '/var/www/html/tareas/app/Model/Logs/');
define('__DEBUG', false);
?>