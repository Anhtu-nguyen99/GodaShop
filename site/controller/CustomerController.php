<?php 
	class CustomerController {
		function infoAccount() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
				include_once "checkLogin.php";
			session_id() || session_start();
			// $page_title = "Thông tin tài khoản";
			
			$customerRepository = new CustomerRepository();
			$email = $_SESSION["email"];
			$customer = $customerRepository->findEmail($email);
			include_once "view/customer/infoAccount.php";
		}

		function saveInfoAccount() {
			include_once "checkLogin.php";
			session_id() || session_start();
			$customerRepository = new CustomerRepository();
			$email = $_SESSION["email"];
			$name = $_POST["fullname"];
			$mobile = $_POST["mobile"];
			$password = $_POST["password"];
			$rePassword = $_POST["re-password"];
			$customer = $customerRepository->findEmail($email);
			$customer->setName($name);
			$customer->setMobile($mobile);
			if (empty($customer->getWardId())) {
				$customer->setWardId('00001');
			}
			if (!empty($password) && $password === $rePassword) {
				$customer->setPassword(md5($password));
			}
			$customerRepository->update($customer);
			$_SESSION["name"] = $name;
			header("location: index.php?c=customer&a=infoAccount");
		}

		function shippingAddress() {
			include_once "checkLogin.php";
			session_id() || session_start();

			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			$customerRepository = new CustomerRepository();
			$email = $_SESSION["email"];
			$customer = $customerRepository->findEmail($email);
			$provinceRepository = new ProvinceRepository();
			$provinces = $provinceRepository->getAll();

			$customer_shipping_name = "";
			$customer_shipping_mobile = "";
			$customer_province_id = "";
			$customer_district_id = "";
			$customer_ward_id = "";
			$districts = array();
			$wards = array();
			$housenumber_street = "";
			if (!empty($customer)) {
			    $customer_ward = $customer->getWard();
			    if (!empty($customer_ward)) {
			        $customer_district = $customer_ward->getDistrict();
			        $customer_province = $customer_district->getProvince();
			        $districts = $customer_province->getDistricts();
			        $wards = $customer_district->getWards();

			        $customer_province_id = $customer_province->getId();
			        $customer_district_id = $customer_district->getId();
			        $customer_ward_id = $customer_ward->getId();
			    } 
			}
			
			include "view/customer/shippingAddress.php";
		}

		function saveShippingAddress() {
			include_once "checkLogin.php";
			session_id() || session_start();
			$email = $_SESSION["email"];
			$customerRepository = new CustomerRepository();
			$customer = $customerRepository->findEmail($email);
			$shipping_name = $_POST["fullname"];
			$shipping_mobile = $_POST["mobile"];
			$ward_id = $_POST["ward"];
			$housenumber_street = $_POST["housenumber_street"];
			$customer->setShippingName($shipping_name);
			$customer->setShippingMobile($shipping_mobile);
			$customer->setWardId($ward_id);
			$customer->setHousenumberStreet($housenumber_street);

			if ($customerRepository->update($customer)) {
				header("location:index.php?c=customer&a=shippingAddress");
		}
	}
	}
?>