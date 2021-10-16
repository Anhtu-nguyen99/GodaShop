<?php 
class HomeController extends BaseController{
	function list() {
		$page_title = "Trang chủ";
		$categories = $this->getCategories();

		$qty_per_page = QTY_PER_PAGE_HOME;
		$page_index = 1;
		$productRepository = new ProductRepository();
		$featuredProducts = $productRepository->getBy(array(), array("featured" => "DESC"),  $page_index, $qty_per_page);

		$newProducts = $productRepository->getBy(array(), array("created_date" => "DESC"), $page_index, $qty_per_page);

		$productByCategories = [];
		foreach($categories as $category) {
			$products = $productRepository->getBy(
				array( 
					"category_id" =>array(
						"type" => "=", 
						"val" => $category->getId()
					)
				), 
				array("created_date" => "DESC"),  $page_index, $qty_per_page);
			$productByCategories[$category->getId()] = $products;
		}



		include_once "view/home/list.php";
	}
}
?>