<?php
include('DBNosql_model.php');

class Log 
{
	public static function Insertlog($collection,$saveMethod,$fields)
	{
		if ($saveMethod=="DBLOG")
		{
			//save in db
			$nameLogDB=$collection."_log";
			$data=new DBNosql($nameLogDB);		
			$result=$data->insertDocument($fields);	
		}
		if ($saveMethod=="FILEDBLOG")
		{
			//save in db and save in archive
			$nameLogDB=$collection."_log";
			$data=new DBNosql($nameLogDB);		
			$result=$data->insertDocument($fields);

			//sabe in archive
			$archivename=$nameLogDB.".txt";
			$file = fopen($archivename, "w");
			$save="collection = ".$collection."||".implode(",", $fields);
			fwrite($file,  $save. PHP_EOL);
			//fwrite($file, "Otra más" . PHP_EOL);
			fclose($file);
		}
		if ($saveMethod=="FILELOG")
		{
			//save in archive
			$nameLogDB=$collection."_log";
			$archivename=$nameLogDB.".txt";
			$file = fopen($archivename, "a");
			$save="collection = ".$collection."||".implode(",", $fields);
			fwrite($file,  $save. PHP_EOL);
			//fwrite($file, "Otra más" . PHP_EOL);
			fclose($file);
		}

		if ($saveMethod=="NOLOG")
		{
			
			
		}
		


		
	}
	public static function listlog($collection)
	{
		$nameLogDB=$collection."_log";
		$fields = array();      
		$data=new DBNosql($nameLogDB);
		$result = $data->selectDocument($fields);
		return $result;
		//echo "<br>";
		//echo "<br>";
	}


}

$obj = array('date'=>'','type'=>'este es el dato de tipo','sender'=>'este es el dato de sernder', 'message'=>'Este es el mensaje', 'request'=>'este es el requerimiento', 'response'=>'esta es la respuesta');
Log::Insertlog("user","FILELOG",$obj);
$result



//$data=new DBNosql;
//$data->conn();

var_dump($result);

?>
