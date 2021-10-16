<?php 
	class CommentController {
		function save() {
			$data = array();
			$data["email"] = $_POST["email"];
			$data["fullname"] = $_POST["fullname"];
			$data["star"] = $_POST["rating"];
			$data["created_date"] = date("Y-m-d H:m:s");
			$data["description"] = $_POST["description"];
			$data["product_id"] = $_POST["product_id"];
			$commentRepository = new CommentRepository();
			$commentRepository->save($data);
			$comments = $commentRepository->getByProductId($data["product_id"]);
			include "view/product/commentList.php";
		}
	}
?>