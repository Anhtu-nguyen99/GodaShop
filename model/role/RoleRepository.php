<?php  
class RoleRepository {
	protected function fetchAll($condition = null) {
		global $conn;
		$categories = array();
		$sql = "SELECT * FROM role";
		if ($condition) {
			$sql .= "WHERE $conditon";
		}

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$row = new Role($row["id"], $row["name"]);
				$categories[] = $row;
			}
		}

		return $categories;
	}

	function find($id) {
		global $conn;
		$conditon = "id = $id";
		$roles = $this->fetchAll();
		$role = current($roles);
		return $role;
	}
}

?>