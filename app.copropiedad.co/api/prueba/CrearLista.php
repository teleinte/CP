<?php
if($_POST)
{
	require_once('/app/Model/DBNosql_model.php');
	$fields = array();      
	$data=new DBNosql('task');
	$result = $data->selectDocument($fields);
	echo "<pre>";
	print_r($result);
	echo "<pre>";
	echo "<br>";
	echo "<br>";

	$data=new DBNosql('task');	
	$obj = array('type'=>'otroDato','building_id'=>'Otro Dato dos','status'=>'esteesotrodato', 'user'=>$_POST['user_name'],'item_title'=>$_POST['item_title'],'item_description'=>'','date'=>'','item_type'=>'');
	$result=$data->insertDocument($obj);
	echo "Id insertado = ".$result;
}


?>

<HTML>
  <HEAD></HEAD>
  <BODY>
  	<form name='envio' method="POST">
  		<input type='text' id='item_title' name='item_title'>
  		<input type='text' id='user_name' name='user_name'>
  		<input type="submit" value="Enviar">
  	</form>
  </BODY>
</HTML>