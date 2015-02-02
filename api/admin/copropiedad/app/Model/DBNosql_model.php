<?php
//ponerle debug si la clase esta en debug on mostrar mensajes en pantalla o en un archivo
require_once("/var/www/html/api/admin/copropiedad/app/Model/config.php");
require_once("/var/www/html/api/admin/copropiedad/app/Model/Log_model.php");

Class DBNosql
{
	private $dbname = __DBNAME;
	Private $collection;
	Private $collectionSet;
	private $ocon;
	private $docs;
	private $limit = __REGISTERLIMIT;
	public function __construct($collection) 
	{ 
        $this->collectionSet=$collection;
        if (__DEBUG)
        {
            $date=date('YmdHis');
            $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>'Cargando Controlador', 'request'=>'Consultas', 'response'=>'');
            Log::Insertlog("db","FILELOG",$objs);
        }        
        $this->conn();
	} 
	public function conn()
    {
        try {
            $this->ocon = new MongoClient("mongodb://".__DBHOST.":".__DBPORT."");
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>'conectando con el servidor MongoDB', 'request'=>'Con', 'response'=>'');
                Log::Insertlog("db","FILELOG",$objs);
            }   
            // Connecting to the database
			$this->dbname = $this->ocon->selectDB($this->dbname);
			// Getting the Collection
			$this->collection = new MongoCollection($this->dbname, $this->collectionSet);                     
        } 
        catch (MongoConnectionException $e) 
        {
            $date=date('YmdHis');
            $obj = array('date'=>$date,'type'=>'ERROR','sender'=>$this->collectionSet, 'message'=>'Error conectando con el servidor MongoDB', 'request'=>'DBConnect', 'response'=>'Error conectando con el servidor MongoDB');
            Log::Insertlog("db","FILELOG",$obj);
            die('Error conectando con el servidor MongoDB');
        } 
        catch (MongoException $e) 
        {
            $date=date('YmdHis');
            $obj = array('date'=>$date,'type'=>'ERROR','sender'=>$this->collectionSet, 'message'=>'Error: '. $e->getMessage(), 'request'=>'DBConnect', 'response'=>'Error: ' . $e->getMessage());
            Log::Insertlog("db","FILELOG",$obj);
            die('Error: ' . $e->getMessage());
        }

    }
    public function insertDocument($obj)
    {
        try
        {
            if (__DEBUG)
            {
                $date=date('YmdHis');                
                $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>$obj, 'request'=>'Insertar documento', 'response'=>'');
                Log::Insertlog("db","FILELOG",$objs);
            }
            $this->collection->insert($obj);            
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>'', 'request'=>'', 'response'=>$obj['_id']);
                Log::Insertlog("db","FILELOG",$objs);
            }
            return  $obj['_id'];
        } 
        catch (MongoException $e)
        {
            $date=date('YmdHis');
            $fix=implode(",", $obj);
            $objs = array('date'=>$date,'type'=>'Error','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'insert', 'response'=>"No pudo Insertar");
            Log::Insertlog("db","FILELOG",$objs);
            return "Can't insert!n";
        }      
    }
    public function selectDocument($fields = array())
    {
        if (__DEBUG)
        {
            $date=date('YmdHis');
            $fix=implode(",", $fields);
            $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'Listar Documentos', 'response'=>'');
            Log::Insertlog("db","FILELOG",$objs);
            $stringDbug="";
        }    	
    	$pointer = $this->collection->find($fields)->limit($this->limit);
        
    	foreach ($pointer as $doc) 
    	{
    		$this->docs[] = $doc;
            //var_dump($this->docs);
            //if (__DEBUG) $stringDbug.=implode(",", $this->docs);
    	}
        if (__DEBUG)
        {

            $date=date('YmdHis'); 
            $fix=implode(",", $fields);                   
            $envio=json_decode(json_encode($this->docs), true);
            //var_dump($envio);
            $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'', 'response'=>$envio);
            Log::Insertlog("db","FILELOG",$objs);
        } 
    	return $this->docs;
    }

    public function updateDocument($fields, $newdata)
    {
    	try
        {
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $objs = array('date'=>$date,'type'=>'Mensaje - UPDATE','sender'=>$this->collectionSet, 'message'=>json_decode(json_encode($fields), true), 'request'=>'', 'response'=>'');
                Log::Insertlog("db","FILELOG",$objs);
            } 
            $this->collection->update($fields,$newdata);
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $objs = array('date'=>$date,'type'=>'Mensaje - UPDATE','sender'=>$this->collectionSet, 'message'=>json_decode(json_encode($newdata), true), 'request'=>'', 'response'=>'Okay');
                Log::Insertlog("db","FILELOG",$objs);
            } 
            return  "Okay";
        } 
        catch (MongoException $e) 
        {
            $date=date('YmdHis');
            $fix=implode(",", $fields);
            $newdata2=implode(",", $newdata);
            $objs = array('date'=>$date,'type'=>'Error - UPDATE','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>$newdata2, 'response'=>"No pudo insertar la informacion");
            Log::Insertlog("db","FILELOG",$objs);
            return '';
        }

    }

    public function removeDocument($fields)
    {
    	try
        {
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $fix=implode(",", $fields);
                $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'remove', 'response'=>'');
                Log::Insertlog("db","FILELOG",$objs);
            }             
            $this->collection->remove($fields);
            if (__DEBUG)
            {
                $date=date('YmdHis');
                $fix=implode(",", $fields);
                $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'', 'response'=>'Okay');
                Log::Insertlog("db","FILELOG",$objs);
            } 
            return  "Okay";
        } 
        catch (MongoException $e) 
        {
            $date=date('YmdHis');
            $fix=implode(",", $fields);
            $objs = array('date'=>$date,'type'=>'Error','sender'=>$this->collectionSet, 'message'=>$fix, 'request'=>'Actualizarndo Documentos', 'response'=>"No puede actualizar los datos");
            Log::Insertlog("db","FILELOG",$objs);
            return "Can't remove";
        }
    }

    Public function __destruct()
    {
    	if (__DEBUG)
        {
            $date=date('YmdHis');
            $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>"Cerrando coneccion", 'request'=>'Terminando', 'response'=>'Terminando');
            Log::Insertlog("db","FILELOG",$objs);
        } 
        $conection = $this->ocon->getConnections();
		foreach ($conection as $con)
		{
		    if ( $con['connection']['connection_type_desc'] == "SECONDARY")
		    {
		        if (__DEBUG)
                {
                    $date=date('YmdHis');
                    $objs = array('date'=>$date,'type'=>'Mensaje','sender'=>$this->collectionSet, 'message'=>"Cerrando '{$con['hash']}': ", 'request'=>'Terminando', 'response'=>$cerrada ? "ok" : "falló", "\n");
                    Log::Insertlog("db","FILELOG",$objs);
                }
                //echo "Cerrando '{$con['hash']}': ";
		        $cerrada = $a->close( $con['hash'] );
		        //echo $cerrada ? "ok" : "falló", "\n";
		    }
		}
    }
}

// $data=new DBNosql('user');
// $obj = array('first_name'=>'otroDato','last_name'=>'Otro Dato dos','title'=>'esteesotrodato', 'ultima informacion'=>'este es el otro dato ya para el final');
// $result=$data->insertDocument($obj);


// $fields = array();      
// $data=new DBNosql('user');
// $result = $data->selectDocument($fields);
// print_r($result);
// echo "<br>";
// echo "<br>";

// $fields = array('first_name'=>'otroDato');      
// $newdata = array('title'=>'GORDO'); 
// $data=new DBNosql('user');
// $data->conn();
// $result = $data->updateDocument($fields, $newdata);
// print_r($result);
// echo "<br>";
// echo "<br>";


// $fields = array('title'=>'GORDO');      
// $data=new DBNosql('user');
// $data->conn();
// $result = $data->removeDocument($fields);
// print_r($result);
// echo "<br>";
// echo "<br>";
//
//$fields      = array();      
//$data=new DBNosql;
//$data->conn();
//$result = $data->selectDocument($fields);
//print_r($result);
//echo "<br>";
//echo "<br>";


?>