<?php 
	class BaseController {
		function getCategories() {
			$categoryRepository = new CategoryRepository();
			$categories = $categoryRepository->getAll();

			return $categories;
		}
	}
?>