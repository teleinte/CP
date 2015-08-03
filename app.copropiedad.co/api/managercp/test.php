<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
define('__LDAPSERVER', 'localhost');
define('__LDAPPORT', '389');
define('__LDAPDN', 'dc=teleinte,dc=com');

/**
 * SimpleLDAP
 *
 * An abstraction layer for LDAP server communication using PHP
 *
 * @author Klaus Silveira <contact@klaussilveira.com>
 * @package simpleldap
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version 0.1
 * @link http://github.com/klaussilveira/SimpleLDAP
 */
class SimpleLDAP {
	
	/**
	 * Holds the LDAP server connection
	 *
	 * @var resource
	 * @access private
	 */
	private $ldap;
	
	/**
	 * Holds the default Distinguished Name. Ex.: ou=users,dc=demo,dc=com
	 *
	 * @var string
	 * @access public
	 */
	public $dn;
	
	/**
	 * Holds the administrator-priviledge Distinguished Name and user. Ex.: cn=admin,dc=demo,dc=com
	 *
	 * @var string
	 * @access public
	 */
	public $adn;
	
	/**
	 * Holds the administrator-priviledge user password. Ex.: 123456
	 *
	 * @var string
	 * @access public
	 */
	public $apass;
	
	/**
	 * LDAP server connection
	 *
	 * In the constructor we initiate a connection with the specified LDAP server 
	 * and optionally allow the setup of LDAP protocol version
	 *
	 * @access public
	 * @param string $hostname Hostname of your LDAP server
	 * @param int $port Port of your LDAP server
	 * @param int $protocol (optional) Protocol version of your LDAP server
	 */
	public function __construct($hostname, $port, $protocol = null) {
		$this->ldap = ldap_connect($hostname, $port);
		
		if($protocol != null) {
			ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, $protocol);
		}
	}
	
	/**
	 * Bind as an administrator in the LDAP server
	 *
	 * Bind as an administrator in order to execute admin-only tasks,
	 * such as add, modify and delete users from the directory.
	 *
	 * @access private
	 * @return bool Returns if the bind was successful or not
	 */
	private function adminBind() {
		$bind = ldap_bind($this->ldap, $this->adn, $this->apass);
		return $bind;
	}
	
	/**
	 * Authenticate an user and return it's information
	 *
	 * In this method we authenticate an user in the LDAP server with the specified username and password
	 * If successful, we return the user information. Otherwise, we'll return false and throw exceptions with error information
	 *
	 * @access public
	 * @param string $user Username to be authenticated
	 * @param string $password Password to be authenticated
	 * @return mixed User information, as an array, on successful authentication, false on error
	 */
	public function auth($user, $password) {
		/**
		 * We bind using the provided information in order to check if the user exists
		 * in the directory and his credentials are valid
		 */
		$bind = ldap_bind($this->ldap, "cn=$user," . $this->dn, $password);
		
		if($bind) {
		
			/**
			 * If the user is logged in, we bind as an administrator and search the directory
			 * for the user information. If successful, we'll return that information as an array
			 */
			if($this->adminBind()) {
				$search = ldap_search($this->ldap, "cn=$user," . $this->dn, "(cn=$user)");
				
				if(!$search) {
					$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
					throw new Exception($error);
				}
				
				$data = ldap_get_entries($this->ldap, $search);
				
				if(!$data) {
					$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
					throw new Exception($error);
				}
				
				return $data;
			} else {
				$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
				throw new Exception($error);
				return false;
			}
		} else {
			$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
			throw new Exception($error);
			return false;
		}
	}
	
	/**
	 * Get users based on a query
	 *
	 * Returns information from users within the directory that match a certain query
	 *
	 * @access public
	 * @param string $filter The search filter used to query the directory. For more info, see: http://www.mozilla.org/directory/csdk-docs/filter.htm
	 * @param array $attributes (optional) An array containing all the attributes you want to request
	 * @return mixed Returns the information if successful or false on error
	 */
	public function getUsers($filter, $attributes = null) {
		if($this->adminBind()) {
			if($attributes !== null) {
				$search = ldap_search($this->ldap, $this->dn, $filter, $attributes);
				if(!$search) {
					$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
					throw new Exception($error);
					return false;
				}
				$data = ldap_get_entries($this->ldap, $search);
				return $data;
			} else {
				$search = ldap_search($this->ldap, $this->dn, $filter);
				if(!$search) {
					$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
					throw new Exception($error);
					return false;
				}
				$data = ldap_get_entries($this->ldap, $search);
				return $data;
			}
		} else {
			$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
			throw new Exception($error);
			return false;
		}
	}
	
	/**
	 * Inserts a new user in LDAP
	 *
	 * This method will take an array of information and create a new entry in the 
	 * LDAP directory using that information.
	 *
	 * @access public
	 * @param string $uid Username that will be created
	 * @param array $data Array of user information to be inserted
	 * @return bool Returns true on success and false on error
	 */
	public function addUser($user, $data) {
		if($this->adminBind()) {
			$add = ldap_add($this->ldap, "cn=$user," . $this->dn, $data);
			var_dump($add);
			if(!$add) {
				$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
				throw new Exception($error);
				return false;
			} else {
				return true;
			}
		} else {
			$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
			throw new Exception($error);
			return false;
		}
	}
	
	/**
	 * Removes an existing user in LDAP
	 *
	 * This method will remove an existing user from the LDAP directory
	 *
	 * @access public
	 * @param string $uid Username that will be removed
	 * @return bool Returns true on success and false on error
	 */
	public function removeUser($user) {
		if($this->adminBind()) {
			$delete = ldap_delete($this->ldap, "cn=$user," . $this->dn);
			if(!$delete) {
				$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
				throw new Exception($error);
				return false;
			} else {
				return true;
			}
		} else {
			$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
			throw new Exception($error);
			return false;
		}
	}
	
	/**
	 * Modifies an existing user in LDAP
	 *
	 * This method will take an array of information and modify an existing entry 
	 * in the LDAP directory using that information.
	 *
	 * @access public
	 * @param string $uid Username that will be modified
	 * @param array $data Array of user information to be modified
	 * @return bool Returns true on success and false on error
	 */
	public function modifyUser($user, $data) {
		if($this->adminBind()) {
			$modify = ldap_modify($this->ldap, "cn=$user," . $this->dn, $data);
			if(!$modify) {
				$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
				throw new Exception($error);
				return false;
			} else {
				return true;
			}
		} else {
			$error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
			throw new Exception($error);
			return false;
		}
	}
	
	/**
	 * Close the LDAP connection
	 *
	 * @access public
	 */
	public function close() {
		ldap_close($this->ldap);
	}
}

function formatLDAPAdd($datos)
{
  $adduser = array();
  $adduser["objectclass"][0] = "top";
  $adduser["objectclass"][1] = "teleintePersona";
  $adduser["c"][0] = $datos->body->paisNacimiento;
  $adduser["cn"][0] = $datos->body->email;
  $adduser["co"][0] = $datos->body->nacionalidad;
  $adduser["description"][0] = $datos->body->apps;
  $adduser["email"][0] = $datos->body->email;
  $adduser["info"][0] = $datos->body->fechaNacimiento;
  $adduser["l"][0] = $datos->body->lugarNacimiento;
  $adduser["name"][0] = $datos->body->nombre;
  $adduser["organizationalstatus"][0] = $datos->body->estado;
  $adduser["sn"][0] = $datos->body->apellido;
  $adduser["preferredlanguage"][0] = $datos->body->idioma;
  $adduser["title"][0] = $datos->body->genero;
  $adduser["uniqueidentifier"][0] = $datos->body->id_crm;
  $adduser["userPassword"][0] = $datos->body->password;

  return $adduser;
}

$ldap = new SimpleLDAP(__LDAPSERVER, __LDAPPORT, 3);
$ldap->dn = __LDAPDN;
$requerimiento = '{
	"token":"186416a8s64df6asd4f6a8s4df16asd4f6as3df",
	"body":
	{
		"nombre" : "Andrea",
		"apellido" : "Cañon",
		"email" : "acanon@teleinte.com",
		"genero" : "F",
		"nacionalidad" : "Colombiana",
		"lugarNacimiento" : "Bogota",
		"paisNacimiento" : "CO",
		"fechaNacimiento" : "01/01/1901",
		"idioma" : "Español",
		"apps" : "1,2",
		"estado" : "1",
		"id_crm" : "123",
		"password" : "123456789"
	}
}';
$datos = json_decode($requerimiento);
//echo $datos->body->email;
$obj = formatLDAPAdd($datos);
//echo $obj["name"][0];
$add_result = $ldap->addUser($datos->body->email, $obj);
//var_dump($add_result);


?>