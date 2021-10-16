<?php
date_default_timezone_set("Asia/Bangkok");
include_once "../config.php";
include_once "../model/connectdb.php";
include_once "../model/category/Category.php";
include_once "../model/category/CategoryRepository.php";
include_once "../model/product/Product.php";
include_once "../model/product/ProductRepository.php";
include_once "../model/brand/Brand.php";
include_once "../model/brand/BrandRepository.php";
include_once "../model/imageItem/ImageItem.php";
include_once "../model/imageItem/ImageItemRepository.php";
include_once "../model/comment/Comment.php";
include_once "../model/comment/CommentRepository.php";
include_once "../model/cart/Cart.php";
include_once "../model/cart/CartStorage.php";
include_once "../model/customer/Customer.php";
include_once "../model/customer/CustomerRepository.php";
include_once "../model/province/Province.php";
include_once "../model/province/ProvinceRepository.php";
include_once "../model/district/District.php";
include_once "../model/district/DistrictRepository.php";
include_once "../model/ward/Ward.php";
include_once "../model/ward/WardRepository.php";
include_once "../model/order/Order.php";
include_once "../model/order/OrderRepository.php";
include_once "../model/orderItem/OrderItem.php";
include_once "../model/orderItem/OrderItemRepository.php";
include_once "../model/status/Status.php";
include_once "../model/status/StatusRepository.php";
include_once "../model/transport/Transport.php";
include_once "../model/transport/TransportRepository.php";

// Mailer
require_once "../vendor/PHPMailer-master/src/PHPMailer.php";
require_once "../vendor/PHPMailer-master/src/Exception.php";
require_once "../vendor/PHPMailer-master/src/OAuth.php";
require_once "../vendor/PHPMailer-master/src/POP3.php";
require_once "../vendor/PHPMailer-master/src/SMTP.php";


function get_full_url() {
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $url;
}

function get_link_site() {
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . $_SERVER['HTTP_HOST'];
	return $url;
}