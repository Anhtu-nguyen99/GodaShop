<?php 
	class InformationController {
		function returnPolicy() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			include_once "view/information/returnPolicy.php";
		}

		function paymentPolicy() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			include_once "view/information/paymentPolicy.php";
		}

		function deliveryPolicy() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();
			include_once "view/information/deliveryPolicy.php";
		}
	}
?>