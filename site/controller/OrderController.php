<?php 
	class OrderController {
		function list() {
			include_once "checkLogin.php";
			session_id() || session_start();
			$page_title = "Đơn hàng của tôi";
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			$customerRepository = new CustomerRepository();
			$email = $_SESSION["email"];
			$customer = $customerRepository->findEmail($email);
			$orderRepository = new OrderRepository();
			$orders = $orderRepository->getByCustomerId($customer->getId());
			include_once "view/order/list.php";
		}

		function detail(){
			include_once "checkLogin.php";
			session_id() || session_start();
			$id = $_GET["id"];
			$page_title = "Đơn hàng #$id";
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			$customerRepository = new CustomerRepository();
			$email = $_SESSION["email"];
			$customer = $customerRepository->findEmail($email);
			$orderRepository = new OrderRepository();
			$order = $orderRepository->find($id);
			include_once "view/order/detail.php";

		}
	}

?>