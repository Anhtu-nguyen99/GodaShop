<?php 
	class PaymentController {
		function checkout() {
			$page_title = "Thông tin đặt hàng";
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			$cartStorage = new CartStorage();
			$cart = $cartStorage->fetch();
			if (empty($cart->getItems())) {
				header("location:index.php?c=product&a=list");
				exit;
			}
			session_id() || session_start();
			$customer = null;
			if (!empty($_SESSION["email"])) {
				$email = $_SESSION["email"];
				$customerRepository = new CustomerRepository();
				$customer = $customerRepository->findEmail($email);
			}
			$provinceRepository = new ProvinceRepository();
			$provinces = $provinceRepository->getAll();
			include_once "view/payment/checkout.php";
		}

		function order() {
		//Create order
			$page_title = "Đã đặt hàng";
			$tranportRepository = new TransportRepository();
			$trasport = $tranportRepository->findByProvinceId($_POST["province"]);
			$shipping_fee = $trasport->getPrice();

			session_id() || session_start();
			// $customer = null;
			$email = GUEST_EMAIL;
			if (!empty($_SESSION["email"])) {
				$email = $_SESSION["email"];
				
			}

			$customerRepository = new CustomerRepository();
			$customer = $customerRepository->findEmail($email);

			$data = array();
			$data["created_date"] = date("Y-m-d H:i:s");
			$data["order_status_id"] = 1;
			$data["staff_id"] = null; 
			$data["customer_id"] = $customer->getId();
			$data["shipping_fullname"] = $_POST["fullname"];
			$data["shipping_mobile"] = $_POST["mobile"];
			$data["payment_method"] = $_POST["payment_method"]; 
			$data["shipping_ward_id"] = $_POST["ward"]; 
			$data["shipping_housenumber_street"] = $_POST["address"]; 
			$data["shipping_fee"] = $shipping_fee; 
			$data["delivered_date"] = date("Y-m-d", strtotime(' +3 day'));//giao hàng sau 3 ngày
			$orderRepository = new OrderRepository();
			if ($order_id = $orderRepository->save($data)) {
				// empty cart
				$cartStorage = new CartStorage();
				$cart = $cartStorage->fetch();
				//save into order detail
				$orderItemRepository = new OrderItemRepository();
				foreach ($cart->getItems() as $item) {
					$detail_data = array();
					$detail_data["order_id"] = $order_id;
					$detail_data["product_id"] = $item["product_id"];
					$detail_data["qty"] = $item["qty"];
					$detail_data["unit_price"] = $item["unit_price"];
					$detail_data["total_price"] = $item["total_price"];
					if(!$orderItemRepository->save($detail_data)) {
						exit();
					}

				}
				$cartStorage->clear();
				header("location:index.php?c=payment&a=finish");
				exit;
			}
		}

		function finish() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			include_once "view/payment/finish.php";
		}
		
	}
?>