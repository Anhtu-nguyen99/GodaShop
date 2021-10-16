<?php 
class ProductController {
	function list() {
		$categoryRepository = new CategoryRepository();
		$categories = $categoryRepository->getAll();
		
		$qty_per_page = QTY_PER_PAGE_PRODUCT;
		$selected_page = !empty($_GET["page"]) ? $_GET["page"] : 1;
		$page_index = 1;
		$productRepository = new ProductRepository();


		$conds = [];

		$selected_category_id = !empty($_GET["category_id"]) ? $_GET["category_id"] : null;
		$selectedCategory = null;
		if ($selected_category_id) {
			$conds["category_id"] = array(
				"type" => "=", 
				"val" => $selected_category_id
			);
			// $selectedCategory = $categoryRepository->find($selected_category_id);
		}

		// sopport get product by price-grand
		$selected_price_range = !empty($_GET["price-range"]) ? $_GET["price-range"] : null;
		if ($selected_price_range) {
			$tmp = explode("-", $selected_price_range);
			$start_price = $tmp[0];
			$end_price = $tmp[1];
			if (!is_numeric($start_price)) {
				$start_price = 0;
			}
			if (!is_numeric($end_price)) {
				$end_price = PHP_INT_MAX; // PHP_INT_MAX là số rất lớn
			}
			$conds["sale_price"] = array(
				"type" => "BETWEEN", 
				"val" => "$start_price AND $end_price"
			);
		}
		// search
		$selected_search =  !empty($_GET["search"]) ? $_GET["search"] : null;
		if ($selected_search) {
			$conds["name"] = array(
				"type" => "LIKE", 
				"val" => "'%$selected_search%'",
			);
		}
		// SELECT * FROM product WHERE sale_price BETWEEN 100000 AND 200000;
		$sorts = [];
		$selected_sort = !empty($_GET["sort"]) ? $_GET["sort"] : null;
		if ($selected_sort) {
			$tmp = explode("-", $selected_sort);
			$m = array(
				"price" => "sale_price",
				"alpha" => "name",
				"created" => "created_date",
			);
			$sorts[$m[$tmp[0]]] = strtoupper($tmp[1]);
		}
		$products = $productRepository->getBy($conds,$sorts,$selected_page ,$qty_per_page);
		$page_total = ceil(count($productRepository->getBy($conds, $sorts))/$qty_per_page);
		include_once"view/product/list.php";
	}

	function detail() {
		$categoryRepository = new CategoryRepository();
		$categories = $categoryRepository->getAll();
		$id = $_GET["id"];
		$productRepository = new ProductRepository();
		$product = $productRepository->find($id);
		$commentRepository = new CommentRepository();
		$comments = $commentRepository->getByProductId($id);
		$selected_category_id = $product->getCategoryId();
		$conds = array();
		$conds["category_id"] = array(
				"type" => "=", 
				"val" => $selected_category_id
			);
		
		$relatedProducts = $productRepository->getBy($conds, array(), 1, 10);

		include_once"view/product/detail.php";
	}
	
	public function ajaxSearch() {
		$pattern = $_GET["pattern"];
		$productRepository = new ProductRepository();
		$products = $productRepository->getByPattern($pattern);
		include_once "view/product/ajaxSearch.php";
	}
	
}
?>