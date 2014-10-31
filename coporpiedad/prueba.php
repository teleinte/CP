<?php
//ponerle debug si la clase esta en debug on mostrar mensajes en pantalla o en un archivo


Class DBNosql
{
	private $dbname='test';
	Private $collection;
	Private $collectionSet;
	private $ocon;
	private $docs;
	private $limit = 50;
	public function __construct($collection) 
	{ 
		$this->collectionSet=$collection;
		$this->conn();

	} 
	public function conn()
    {
        
            $this->ocon = new MongoClient("mongodb://localhost:27017");
            // Connecting to the database
			$this->dbname = $this->ocon->selectDB($this->dbname);
			// Getting the Collection
			$this->collection = new MongoCollection($this->dbname, $this->collectionSet);

    }

    public function insertDocument($obj)
    {
    	
        try{
            $this->collection->insert($obj);
            return  $obj['_id'];
        } catch (MongoException $e) {
            return "Can't insert!n";
        }      
    }

    public function selectDocument($fields = array())
    {
    	
    	$pointer = $this->collection->find($fields)->limit($this->limit);
    	foreach ($pointer as $doc) 
    	{
    		$this->docs[] = $doc;
    	} 
    	return $this->docs;
    }

    public function updateDocument($fields, $newdata)
    {
    	try{
            $this->collection->update($fields,$newdata);
            return  "Okay";
        } catch (MongoException $e) {
            return "Can't insert!n";
        }

    }

    public function removeDocument($fields)
    {
    	try{
            $this->collection->remove($fields);
            return  "Okay";
        } catch (MongoException $e) {
            return "Can't insert!n";
        }
    }

    Public function __destruct()
    {
    	$conection = $this->ocon->getConnections();
		foreach ($conection as $con)
		{
		    // Iterar sobre todas las conexiones, y cuando el tipo es "SECONDARY"
		    // cerramos la conexión
		    if ( $con['connection']['connection_type_desc'] == "SECONDARY" )
		    {
		        echo "Cerrando '{$con['hash']}': ";
		        $cerrada = $a->close( $con['hash'] );
		        echo $cerrada ? "ok" : "falló", "\n";
		    }
		}
    }



}

//$data=new DBNosql;
//$data->conn();
//$obj = array('first_name'=>'otroDato','last_name'=>'Otro Dato dos','title'=>'esteesotrodato', 'ultima informacion'=>'este es el otro dato ya para el final');
//$result=$data->insertDocument($obj);


$fields = array();      
$data=new DBNosql('user');
$result = $data->selectDocument($fields);
print_r($result);
echo "<br>";
echo "<br>";

//$fields = array('title'=>'fat');      
//$newdata = array('title'=>'GORDO'); 
//$data=new DBNosql;
//$data->conn();
//$result = $data->updateDocument($fields, $newdata);
//print_r($result);
//echo "<br>";
//echo "<br>";


//$fields = array('title'=>'fat');
//$data=new DBNosql;
//$data->conn();
//$result = $data->selectDocument($fields);
//print_r($result);
//echo "<br>";
//echo "<br>";
//
//
//$fields      = array();      
//$data=new DBNosql;
//$data->conn();
//$result = $data->selectDocument($fields);
//print_r($result);
//echo "<br>";
//echo "<br>";
//
//*/
//$fields = array('title'=>'GORDO');      
//$data=new DBNosql;
//$data->conn();
//$result = $data->removeDocument($fields);
//print_r($result);
//echo "<br>";
//echo "<br>";
//
//$fields      = array();      
//$data=new DBNosql;
//$data->conn();
//$result = $data->selectDocument($fields);
//print_r($result);
//echo "<br>";
//echo "<br>";


?>