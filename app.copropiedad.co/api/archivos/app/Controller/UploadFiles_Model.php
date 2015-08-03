<?php
if (!class_exists('S3'))require_once('S3.php');
Class UploadFiles
{
	public function __construct(){}
	Public function Upload($Archive)
	{
		$s3 = new S3(__AWSACCESSKEY, __AWSSECRETKEY);
		$bucket = __BUCKET;
		$fileName = $_FILES[$Archive]['name'];
		$fileTempName = $_FILES[$Archive]['tmp_name'];
		//$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

		if ($s3->putObjectFile($uploadFile, $bucketName, baseName($uploadFile), S3::ACL_PUBLIC_READ)) {
		echo "S3::putObjectFile(): File copied to {$bucketName}/".baseName($uploadFile).PHP_EOL;


		if ($s3->putObjectFile($fileTempName, $bucket, $fileName, S3::ACL_PUBLIC_READ)) 
		{
			echo "<br>";
			echo "S3::putObjectFile(): File copied to {$bucketName}/".$fileName.PHP_EOL;
			echo "<strong>Archivo subido correctamente.</strong>";
		}
		else
		{
			echo "<strong>No se pudo subir el archivo.</strong>";
		}

	}
	Public function GetFile($nameFile)
	{
		$s3 = new S3(__AWSACCESSKEY, __AWSSECRETKEY);
		$bucket = __BUCKET;
		$fileName = $_FILES[$Archive]['name'];
		$fileTempName = $_FILES[$Archive]['tmp_name'];
		//$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
		if ($s3->putObjectFile($fileTempName, $bucket, $fileName, S3::ACL_PUBLIC_READ)) 
		{
			echo "<strong>Archivo subido correctamente.</strong>";
		}
		else
		{
			echo "<strong>No se pudo subir el archivo.</strong>";
		}

	}

}

	
	
	// Cuendo presiono el boton Upload
	if(isset($_POST['Submit'])){
			
		// Recibo las variables por POST
		$fileName = $_FILES['theFile']['name'];
		$fileTempName = $_FILES['theFile']['tmp_name'];
				
		// Creo un nuevo bucket de Amazon S3
		$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
				
		// Muevo el archivo de su ruta temporal a su ruta definitiva
		if ($s3->putObjectFile($fileTempName, $bucket, $fileName, S3::ACL_PUBLIC_READ)) {
			echo "<strong>Archivo subido correctamente.</strong>";
		}else{
			echo "<strong>No se pudo subir el archivo.</strong>";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cargar archivo en S3 con PHP</title>
    </head>

<body>
<h1>Cagar Archivos</h1>
<p>Seleccione el archivo que desea subir.</p>
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      	<input name="theFile" type="file" />
      	<input name="Submit" type="submit" value="Upload">
	</form>
<h1>Lista de archivos en el S3</h1>
<?php
	// Listamos el contenido del Bucket de Amazon S3 
	$contents = $s3->getBucket($bucket);
	foreach ($contents as $file){
	
		$fname = $file['name'];
		$furl = "http://".$bucket.".s3.amazonaws.com/".$fname;
		
		// Imprimo el archivo que voy encontrando
		echo "<a href=\"$furl\">$fname</a><br />";
	}
?>
</body>
</html>
