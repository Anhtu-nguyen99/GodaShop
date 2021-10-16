<?php  
class DashBoardController {
	function list() {
		$duration = !empty($_GET["duration"]) ? $_GET["duration"] : "today";
		switch ($duration) {
			case 'today':
				$from = date("Y-m-d");
				$to = date("Y-m-d");
				break;
			case 'yesterday':
				$from = date('Y-m-d',strtotime("-1 days"));
				$to = date('Y-m-d',strtotime("-1 days"));
				break;
			case 'this week':
				$from = date('Y-m-d',strtotime("this week"));
				$to = date("Y-m-d");
				break;
			case 'this month':
				$from = date('Y-m-d',strtotime("this month"));
				$to = date("Y-m-d");
				break;
			case 'this three month':
				$from = date('Y-m-d',strtotime("this month"));
				$to = date("Y-m-d");
				break;
			case 'this year':
				$from = date('Y-01-01');
				$to = date("Y-m-d");
				break;
			default:
				# code...
				break;
		}

		if (!empty($_GET["custom"])) {
		$from = !empty($_GET["from"]) ? $_GET["from"] : date("Y-m-d");
		$to = !empty($_GET["to"]) ? $_GET["to"] : date("Y-m-d");
		}

		$conds = array();
		$conds["DATE(created_date)"] = array(
				"type" => "BETWEEN", 
				"val" => "'$from' AND '$to'"
			);
		$orderRepository = new OrderRepository();
		$orders = $orderRepository->getBy($conds);
		include_once "view/dashboard/list.php";
	}
}
?>