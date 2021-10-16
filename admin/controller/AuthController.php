<?php 
class AuthController {
	function login() {
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
		$staffRepository = new StaffRepository();
		$staff = $staffRepository->findUsernameAndPassword($username, $password);
		if (!empty($staff)) {
			session_id() || session_start();
			unset($_SESSION["email"]);
			$_SESSION["username"] = $username;
			$_SESSION["name"] = $staff->getName();
			if (!empty($_POST["remember-me"])){

				// Store to cookie to remmber for next login
				$payload = array(
					"username" => $username
				);
				$jwt = Firebase\JWT\JWT::encode($payload, JWT_SECRET_KEY);
				setcookie("remember_me_id", $jwt, time() + 3600 * 24 * 3);
				setcookie("remember_me_name", $_SESSION["name"], time() + 3600 * 24 * 3);
			}
		}

		header("location:index.php");
		exit;
	}

	function logout() {
		session_id() || session_start();
		session_destroy();
		setcookie("remember_me_id", "", time() - 3600 * 24 * 3);
		setcookie("remember_me_name", "", time() - 3600 * 24 * 3);
		header("location: login.html");
		exit;
	}	
}

?>