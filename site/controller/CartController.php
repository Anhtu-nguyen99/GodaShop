<?php 
	class CartController {
		protected $cartStorage;

		function __construct() {
			$this->cartStorage = new CartStorage();
		}

		function add() {
			$product_id = $_GET["product_id"];
			$qty = $_GET["qty"];
			$cart = $this->cartStorage->fetch();
			$cart->addProduct($product_id, $qty);

			$this->cartStorage->store($cart);
			echo json_encode($cart->convertToArray());
		}

		function display() {
			$cart = $this->cartStorage->fetch();
			echo json_encode($cart->convertToArray());
		}

		function delete() {
			$product_id = $_GET["product_id"];
			$cart = $this->cartStorage->fetch();
			$cart->deleteProduct($product_id);
			echo json_encode($cart->convertToArray());
			$this->cartStorage->store($cart);
		}

		function update() {
			$product_id = $_GET["product_id"];
			$qty = $_GET["qty"];
			$more = isset($_GET["more"]) ? $_GET["more"] : 0;
			$cart = $this->cartStorage->fetch();
			if (!$more) {
				$cart->deleteProduct($product_id);
			}
			$cart->addProduct($product_id, $qty);
			echo json_encode($cart->convertToArray());
			$this->cartStorage->store($cart);
		}
	}
?>