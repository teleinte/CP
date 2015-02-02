<?php
///////////////////// Archivo de configuraciones para los sistemas
////// Definicion de zona horaria
//definir la zona horaria
date_default_timezone_set('America/Bogota');
///// definicion del sistema s3
///// AccesKey, AccesSecret, Bucket
define('__AWSACCESSKEY', 'AKIAJNA6MMTXX3K57S2A');
define('__AWSSECRETKEY', '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');
define('__BUCKET', 'copropiedad');
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
define('__LOGSROUTE', 'C:\xampp\htdocs\copropiedad\app\Model\Logs\\');
define('__DEBUG', false);
////// definicion de archivos
define('__ARCHIVEROUTE','C:\xampp\htdocs\archivos\app\Upload\\');
define('__S3',true);

?>