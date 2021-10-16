<?php  
class Staff {
	protected $id;
	protected $name;
	protected $mobile;
	protected $username;
	protected $password;
	protected $email;
	protected $role_id;

	function __construct($id, $name, $mobile, $username, $password, $email, $role_id) {
		$this->id = $id;
		$this->namename = $name;
		$this->mobile = $mobile;
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->role_id = $role_id;	
	}

	function getId(){
		return $this->id;
	}

	function getName(){
		return $this->name;
	}

	function getMobile(){
		return $this->mobile;
	}

	function getUsername(){
		return $this->username;
	}

	function getPassword(){
		return $this->password;
	}

	function getEmail(){
		return $this->email;
	}

	function getRoleId(){
		return $this->role_id;
	}

	function setName($name){
		$this->name = $name;
		return $this;
	}

	function setUsername($username){
	$this->username = $username;
	return $this;
	}

	function setPassword($password){
	$this->password = $password;
	return $this;
	}

	function setEmail($email){
	$this->email = $email;
	return $this;
	}

	function setRoleId($role_id){
	$this->role_id = $role_id;
	return $this;
	}

	function getRole() {
		$roleReporitory = new roleReporitory();
		$role = $roleReporitory->find($this->role_id);
		return $role;
	}


}
?>