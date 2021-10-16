<?php 
	class AuthController {
		function loginRegular() {
			$email = $_POST["email"];
			$password = md5($_POST["password"]);
			$reference = $_POST["reference"];
			$customerRepository = new CustomerRepository();
			$customer = $customerRepository->findEmailAndPassword($email, $password);
			if (!empty($customer)) {
				session_id() || session_start();
				// unset($_SESSION["username"]);
				$_SESSION["email"] = $email;
				$_SESSION["name"] = $customer->getName();
			}
			header("location: $reference");
			exit;
		}

		function logout() {
			session_id() || session_start();
			session_destroy();
			header("location: index.php");
		}
	}
?>