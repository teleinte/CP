<?php
$out = '<div class="floatleft">';
$url = parse_url(curPageURL());
$parts = explode("/",trim($url['path'], "/"));
$host = $url['scheme'] . '://' . $url['host'];
$out .= '<a href="' . $host . '/inicio/">Escritorio</a>';
$ruta = $host;
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$inicio = "https://appdes.copropiedad.co/inicio/";
$inicio2 = "https://appdes.copropiedad.co/inicio";
$pagos = "https://appdes.copropiedad.co/perfil/mis-pagos.php";
$empresa = "https://appdes.copropiedad.co/perfil/mi-empresa.php";

foreach ($parts as $key => $value) 
{	
	$ruta .= '/' . $value;
	if($value != "index.php")
		$out .= ' > <a href="' . $ruta . '">' . ucfirst(str_replace('_',' ',str_replace('.php','', str_replace('-', ' ', $value)))) . '</a>';
}

if($actual_link == $inicio || $actual_link == $inicio2)
{
	$out = '<div class="floatleft">';
}

if($actual_link == $empresa)
{
	$out = '<div class="floatleft">  <a href="https://appdes.copropiedad.co/inicio/">Escritorio</a> &gt; <a href="https://appdes.copropiedad.co/perfil/mi-empresa.php">Mi empresa</a>';
}

if($actual_link == $pagos)
{
	$out = '<div class="floatleft">  <a href="https://appdes.copropiedad.co/inicio/">Escritorio</a> &gt; <a href="https://appdes.copropiedad.co/perfil/mis-pagos.php">Mis pagos</a>';
}

$out .= '</div>';

echo $out;

function curPageURL() 
{
	$pageURL = 'http';
	
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80") 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	return $pageURL;
}
?>