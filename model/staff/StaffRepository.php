<?php  
class StaffRepository {
	protected function fetchAll($condition = null) {
		global $conn;
		$staffs = array();
		$sql = "SELECT * FROM staff";
		if ($condition) {
			$sql .= " WHERE $condition";
		}

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$staff = new staff($row["id"], $row["name"], $row["mobile"], $row["username"], $row["password"], $row["email"], $row["role_id"])
				$staffs[] = $staff;
			}
		}

		return $staffs;
	}

	function getAll() {
		return $this->fetchAll();
	}

	function Find() {
		global $conn;
		$condition = "id = $id";
		$staffs = $this->fetchAll($condition);
		$staff = current($staffs);
		return $staff;
	}

	function findUsernameAndPassword($username, $password) {
	global $conn; 
	$condition = "username='$username' AND password='$password'";
	$staffs = $this->fetchAll($condition);
	$staff = current($staffs);
	return $staff;
	}
}

?>