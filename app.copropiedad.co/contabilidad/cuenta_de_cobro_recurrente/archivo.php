<?php 
if(empty($_POST['content']) && empty($_POST['idcp'])){
    exit;
}

file_put_contents("plantillas/plantillacargos" . $_POST['idcp'] . ".csv" , $_POST['content']);
echo "plantillas/plantillacargos" . $_POST['idcp'] . ".csv";
?>