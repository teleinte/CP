<?php
class DbModel
{
	private $db_usuario ="root";
	private $db_pass ="";
	private $db_serv ="localhost";
	private $db_base ="pruebalogin";
	private $result ="";

	public function __construct()
	{
		$this->db_con = new mysqli($this->db_serv,$this->db_usuario,$this->db_pass,$this->db_base);
		if ($this->db_con->connect_errno)
		{
			echo "no se pudo conectar con la base de datos".$this->db_con->connect_errno;
			return "DbError1";
		}
		else
		{
			$this->db_con->set_charset("utf8");
		}

	}
}
?>