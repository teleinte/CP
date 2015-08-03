<?php
require_once('/datos/app.copropiedad.co/api/unidad/app/Model/DBNosql_model.php');

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

			//save in archive
			$archivename=__LOGSROUTE.$nameLogDB.".txt";			
			$file = fopen($archivename, "w");
			$save="collection = ".$collection."||".implode(",", $fields);
			fwrite($file,  $save. PHP_EOL);			
			fclose($file);
		}
		if ($saveMethod=="FILELOG")
		{
			//save in archive
			$nameLogDB=__LOGSROUTE.$collection."_log";
			$archivename=$nameLogDB.".txt";			
			$file = fopen($archivename, "a");
			$res = array(); 
			foreach($fields as $k){ if (is_array($k)){foreach($k as $y){if (is_array($y)){foreach($y as $m){if (is_array($m)){foreach($m as $z){if (is_array($z)){foreach($z as $p){$res[]=$p;}}else $res[]=$z;}}else $res[]=$m;}}else $res[]=$y;}} else{$res[]=$k;}}
			//var_dump($res);
			$save="collection = ".$collection."||".implode(",", $res);
			fwrite($file,  $save. PHP_EOL);			
			fclose($file);
		}

		if ($saveMethod=="NOLOG")
		{
			return true;			
		}
	}
	public static function listlog($collection)
	{
		$nameLogDB=__LOGSROUTE.$collection."_log";
		$fields = array();      
		$data=new DBNosql($nameLogDB);
		$result = $data->selectDocument($fields);
		return $result;
	}


}

// $obj = array('date'=>'','type'=>'este es el dato de tipo','sender'=>'este es el dato de sernder', 'message'=>'Este es el mensaje', 'request'=>'este es el requerimiento', 'response'=>'esta es la respuesta');
// Log::Insertlog("user","FILELOG",$obj);
// $result



// //$data=new DBNosql;
// //$data->conn();

// var_dump($result);

?>
