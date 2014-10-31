<?php
function getUserLogin($usuario,$pass)
{
	//echo 'SELECT * FROM usuarios where usuario="'.$usuario.'" and
	password="'.$pass.'";
	$result=$this->db_con->query('');
	if ($result)
	{
		$user=$result->fetch_all(MYSQLI_ASSOC);
		if ($user) return $user;
		else return "Error1";
	}
	else return "Error1";
}

function getData()
{
	$result=$this->db_con->query('');
	$user=$result->fetch_all(MYSQLI_ASSOC);
	if ($user)return $user;
	else return "Error6";
}

function getAllData()
{
	$result=$this->db_con->query('');
	$user=$result->fetch_all(MYSQLI_ASSOC);
	if ($user)return $user;
	else return "Error2";
}

function setData()
{
	$result=$this->db_con->query('');
	if ($this->db_con->insert_id) return "ok";
	else return "Error3";
	//if ($user)return $user;
	//else return "ErrorUsu2";
}
function deleteData()
{
	$result=$this->db_con->query('');
	if ($this->db_con->affected_rows) return "ok";
	else return "Error4";
	//if ($user)return $user;
	//else return "ErrorUsu2";
}

function UpdateFinalUser()
{
	$result=$this->db_con->query('');
	if ($this->db_con->affected_rows) return "ok";
	else return "Error9";
	//if ($user)return $user;
	//else return "ErrorUsu2";
}
?>