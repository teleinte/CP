<?php
require_once('app/Model/config.php');
require_once("app/Model/Log_Model.php");

require 'aws.phar';
use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Aws\Common\Aws;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;
use Guzzle\Http\EntityBody;

class uploadmodel
{
	private $ext_permitidas = array('jpg','jpeg','gif','png','doc','docx','jpg','ppt','pptx','pdf','xls','xlsx');
	private $bucketname = __BUCKET; 
	private $configuracion = array('key' => __AWSACCESSKEY,'secret' => __AWSSECRETKEY,'region' => Region::US_EAST_1);
	private $archivo='';
	private $rutaArchivo = __ARCHIVEROUTE;
	private $nombreArchivo = '';
	private $nombre_tmp = '';	
	private $medio = '';
	private $path = '';
	private $nombre = '';
	private $fullfilename = '';
	private $operacion;
	private $identificador;
	public $ResultadoGeneral;

	public function __construct($medio,$archivo,$operacion,$identificador)
	{
		$this->medio = $medio;
		$this->archivo = $archivo;
		$this->operacion = $operacion;
		$this->identificador = $identificador;

		if ($this->medio =='S3' and $this->operacion =='ingreso')
		{
			$result=$this->subirS3();
		}
		if ($this->medio =='S3' and $this->operacion =='salida')
		{
			$result=$this->bajarS3();
		}
		if ($this->medio =='LOCAL' and $this->operacion =='ingreso')
		{
			$result=$this->subirLocal();
		} 
	}

	private function subirS3()
	{
		if($this->validarArchivo())
		{			
			$s3 = S3Client::factory($this->configuracion);
			try 
			{
				$fecha = date('YmdHis');
			    $bucketname = $this->bucketname;
			    $filename = $this->identificador."_".$fecha."_".$this->nombre;
			    //$filename = $this->identificador."/ventas/".$this->nombre;
			    $path = $this->nombre_tmp;
			    $fullfilename = $this->path;
			    $result= $s3->putObject(array(
			        'Bucket' => $bucketname,
			        'Key'    => $filename, 
			        'Body'   => EntityBody::factory(fopen($fullfilename, 'r')),
			        'ACL'    => CannedAcl::PUBLIC_READ_WRITE
			        
			    ));
			    $this->ResultadoGeneral=$result['ObjectURL'];
			    return($this->ResultadoGeneral);
			} 
			catch (S3Exception $e) 
			{
			    return $e;
			}
		}
		else
		{
			return "archivo no permitido";
		}
	}

	public function bajarS3()
	{		
		$s3 = S3Client::factory($this->configuracion);
		try
		{
			$fecha = date('YmdHis');
		    $bucketname = $this->bucketname;
		    $filename = $fecha."_".$this->nombre;
		    $path = $this->nombre_tmp;
		    $fullfilename = $this->path;

		    $result = $s3->deleteObject(array(
		        'Bucket' => $bucketname,
		        'Key'    => $filename		        
		    ));	
		    //var_dump($result);
		    $this->ResultadoGeneral=$result['DeleteMarker'];		    
		}
		catch (S3Exception $e) 
		{
		    return $e;
		}
	}

	private function subirLocal()
	{
		if($this->validarArchivo())
		{
			if( $this->archivo['error'] > 0 )
		    {
		      return 'Error: '.$this->archivo['error'].'<br/>';
		    }
		    else
		    {
		    	$fecha = date('YmdHis');
		    	if (move_uploaded_file($this->nombre_tmp, $this->rutaArchivo.$fecha."_".$this->nombre))
		    	{
		    		$this->ResultadoGeneral=$this->rutaArchivo.$fecha."_".$this->nombre;
		    	}
		    	else
		    	{
		    		$this->ResultadoGeneral="Error";
		    	}		    	
		    }
		}
		else
		{
			return "archivo no permitido";
		}
	}

	private function validarArchivo()
	{
		$fecha = date('YmdHis');				
		$routeFile=$this->rutaArchivo;
		$nombre =  str_replace(' ', '', $this->archivo['name']);	
		$nombre = strtr($nombre,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');  
		$this->nombre =$nombre;
		$this->nombre_tmp = $this->archivo['tmp_name'];
		$tipo = $this->archivo['type'];
		$tamano = $this->archivo['size'];
	    $ext_permitidas = array('jpg','jpeg','gif','png','doc','docx','jpg','ppt','pptx','pdf','xls','xlsx','txt');;
		$partes_nombre = explode('.', $nombre);
		$extension = end( $partes_nombre );
		$ext_correcta = in_array($extension, $ext_permitidas);
	    $limite = 500 * 1024;	
	    //var_dump($this->identificador);		 
	    $this->nombreArchivo = $this->identificador."_".$fecha."_".$nombre;
	    $this->path = $this->nombre_tmp;
	    $this->fullfilename = $this->path;
		if( $ext_correcta && $tamano <= $limite )
		{	
			return true;
		} 
		else
		{
			return false;
		}
	}
}


?>