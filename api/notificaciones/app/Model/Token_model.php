<?php
/////incluyendo archivo de configuraciondel sistema
require_once('config.php');
require_once("/var/www/html/api/notificaciones/app/Model/Log_model.php");
///definir la zona horaria
date_default_timezone_set('America/Bogota');

class Token
{
	private $tokens="";
	private $fields="";
	private static $Key = __KEY;

	public function GetToken($fields=array())
	{
		if (__DEBUG)
        {
            $date=date('YmdHis');
            $campos=implode(",",$fields);
            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Solicitud de token', 'request'=>'GetToken'.$campos, 'response'=>'null');
            Log::Insertlog("tokens","FILELOG",$objs);
        }

        $date=date('YmdHis');
        $campos=implode(",",$fields);
        $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Solicitud de token', 'request'=>'GetToken'.$campos, 'response'=>'null');
        Log::Insertlog("tokens","DBLOG",$objs);

    	$this->fields=$fields;		
		$fechaInicial 	= date('YmdHis', (strtotime (__TIMELIVETOKEN)));
		array_push($this->fields, $fechaInicial);
		//pasar de arreglo a string
		$separated = implode("|", $this->fields);
		//Proceso para generar el token de seguridad
		$this->tokens = $this->Encrypt($separated);
		if (__DEBUG)
        {
            $date=date('YmdHis');
            $campos=implode(",",$fields);
            $objs = array('date'=>$date,'type'=>'Message','sender'=>"", 'message'=>'Token Entregado', 'request'=>'Solicitud de token', 'response'=>$this->tokens);
            Log::Insertlog("tokens","FILELOG",$objs);
        }

        $date=date('YmdHis');
        $campos=implode(",",$fields);
        $objs = array('date'=>$date,'type'=>'Message','sender'=>"", 'message'=>'Token Entregado', 'request'=>'Solicitud de token', 'response'=>$this->tokens);
        Log::Insertlog("tokens","DBLOG",$objs);

		return $this->tokens;
	}
	public function SetToken($token)
	{
		if (__DEBUG)
        {
            $date=date('YmdHis');            
            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Validacion de token', 'request'=>'SetToken'.$token, 'response'=>'null');
            Log::Insertlog("tokens","FILELOG",$objs);
        }

      	$date=date('YmdHis');            
        $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Validacion de token', 'request'=>'SetToken'.$token, 'response'=>'null');
        Log::Insertlog("tokens","DBLOG",$objs);

		$this->tokens = $token;
		$result = $this->Decrypt($this->tokens );
		$part = explode("|",$result);
		$dateToken = end($part);
		$dateNow = date('YmdHis');
		//if (__DEBUG) echo "<br>fecha del token--> ".$dateToken." fecha del sistema-->".$dateNow."<br>\n"; 
		if (is_numeric($dateToken) and $dateToken > $dateNow)
		{
			if (__DEBUG)
	        {
	            $date=date('YmdHis');            
	            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Token validado con exito', 'request'=>'SetToken'.$token, 'response'=>'True');
	            Log::Insertlog("tokens","FILELOG",$objs);
	        }
	        $date=date('YmdHis');            
            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Token validado con exito', 'request'=>'SetToken'.$token, 'response'=>'True');
            Log::Insertlog("tokens","DBLOG",$objs);
			return true;
		}
		else
		{			
			if (__DEBUG)
	        {
	            $date=date('YmdHis');            
	            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Error Validando el token token vencido', 'request'=>'SetToken'.$token, 'response'=>'False');
	            Log::Insertlog("tokens","FILELOG",$objs);
	        }
	        $date=date('YmdHis');            
            $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Error Validando el token token vencido', 'request'=>'SetToken'.$token, 'response'=>'False');
            Log::Insertlog("tokens","DBLOG",$objs);
	        return false;
		}
	}
	private function Encrypt($data)
	{
		$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Token::$Key), $data, MCRYPT_MODE_CBC, md5(md5(Token ::$Key))));
		return $output;
	}
	private function Decrypt($data)
	{
		$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Token::$Key), base64_decode($data), MCRYPT_MODE_CBC, md5(md5(Token::$Key))), "\0");
		return $output;
	}
}
// //pedir token de seguridad
// $obj = array('Primer'=>'uno','Segundo'=>'segundo','tercero'=>'tercero', 'cuarto'=>'cuarto');
// $token = new Token;
// $tokenEntregado = $token->GetToken($obj);
// echo "Este es el token entregado--->".$tokenEntregado;

// //validar token de seguridad
// //pedir token de seguridad
// $token2 = new Token;
// $tokenEntregado2 = $token2->SetToken("NfcIvSt+f+gQ9cKFdOwKU5OPUButcs6bEN+n6ugSIV9+04X9DopK18DqarRr418XghOkuGb7j6wnZM7Qg3b4og==");
// echo "<br>Este es el token validado--->".$tokenEntregado2;

// $fields = array();
// $data=new DBNosql('tokens_log');
// $result = $data->selectDocument($fields);
// print_r($result);
// echo "<br>";
// echo "<br>";
?>