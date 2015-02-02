<?php
///////////////////// Archivo de configuraciones para los sistemas
////// Definicion de zona horaria
//definir la zona horaria
date_default_timezone_set('America/Bogota');
///// definicion del sistema s3
///// AccesKey, AccesSecret, Bucket
define('__AWSACCESSKEY', 'xxxxxxxxxxxxxxxxxx');
define('__AWSSECRETKEY', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('__BUCKET', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
///// definiciones del token
///// Token Key
define('__KEY', 'J4!r06¡l');
define('__TIMELIVETOKEN', '+24 Hour');
////// definicio de la base de datos
define('__DBNAME', 'copropiedad');
define('__DBHOST', 'Localhost');
define('__DBPORT', 27017);
define('__REGISTERLIMIT', 5000);
////// definicion de rutas de logs
define('__LOGSROUTE', 'C:\xampp\htdocs\tareas\app\Model\Logs\\');
define('__DEBUG', false);
?>