<?php include_once "layout/header.php"; ?>
<?php
$customer_shipping_name = "";
$customer_shipping_mobile = "";
$customer_province_id = "";
$customer_district_id = "";
$customer_ward_id = "";
$districts = array();
$wards = array();
$housenumber_street = "";
$shipping_fee = 0;
if (!empty($customer)) {
    $customer_shipping_name = $customer->getShippingName();
    $customer_shipping_mobile = $customer->getShippingMobile();
    $customer_ward = $customer->getWard();
    if (!empty($customer_ward)) {
        $customer_district = $customer_ward->getDistrict();
        $customer_province = $customer_district->getProvince();
        $districts = $customer_province->getDistricts();
        $wards = $customer_district->getWards();

        $customer_province_id = $customer_province->getId();
        $customer_district_id = $customer_district->getId();
        $customer_ward_id = $customer_ward->getId();
        $shipping_fee = $customer_province->getShippingFee();
    }
    $housenumber_street = $customer->getHousenumberStreet();
}
?>
    <main id="maincontent" class="page-main">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="/" target="_self">Giỏ hàng</a></li>
                        <li><span>/</span></li>
                        <li class="active"><span>Thông tin giao hàng</span></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <aside class="col-md-6 cart-checkout">
                    <?php foreach($cart->getItems() as $item) { ?>
                    <div class="row">
                        <div class="col-xs-2">
                            <img class="img-responsive" src="../upload/<?=$item["img"]?>" alt="<?=$item["name"]?>"> 
                        </div>
                        <div class="col-xs-7">
                            <a class="product-name" href="index.php?c=product&a=detail&id=<?=$item["product_id"]?>"><?=$item["name"]?></a> 
                            <br>
                            <span><?=$item["qty"]?></span> x <span><?=number_format($item["unit_price"])?>₫</span>
                        </div>
                        <div class="col-xs-3 text-right">
                            <span><?=number_format($item["total_price"])?>₫</span>
                        </div>
                    </div>
                    <hr>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-6">
                            Tạm tính
                        </div>
                        <div class="col-xs-6 text-right">
                            <?=number_format($cart->getTotalPrice())?>₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Phí vận chuyển
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="shipping-fee" data=""><?=number_format($shipping_fee)?>₫</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6">
                            Tổng cộng
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="payment-total" data="1230000"><?=number_format($cart->getTotalPrice() + $shipping_fee)?>₫</span>
                        </div>
                    </div>
                </aside>
                <div class="ship-checkout col-md-6">
                    <h4>Thông tin giao hàng</h4>
                    <?php if(empty($customer)) {?>
                    <div>Bạn đã có tài khoản? <a href="javascript:void(0)" class="btn-login">Đăng Nhập  </a></div>
                    <br>
                    <?php } ?>
                    <form action="index.php?c=payment&a=order" method="POST">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <input type="text" value="<?=$customer_shipping_name?>" class="form-control" name="fullname" placeholder="Họ và tên" required="" oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-6">
                                <input type="tel" value="<?=$customer_shipping_mobile?>" class="form-control" name="mobile" placeholder="Số điện thoại" required="" pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-4">
                                <select name="province" class="form-control province" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')" oninput="this.setCustomValidity('')">
                                    <option value="">Tỉnh / thành phố</option>
                                    <?php foreach ($provinces as $province) { ?>
                                    <option value="<?=$province->getId()?>" <?=$customer_province_id == $province->getId() ? 'selected' : ''?>><?=$province->getName()?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <select name="district" class="form-control district" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
                                    <option value="">Quận / huyện</option>
                                    <?php foreach ($districts as $district) { ?>
                                    <option value="<?=$district->getId()?>" <?=$customer_district_id == $district->getId() ? 'selected' : ''?>><?=$district->getName()?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
                                    <option value="">Phường / xã</option>
                                    <?php foreach ($wards as $ward) { ?>
                                    <option value="<?=$ward->getId()?>" <?=$customer_ward_id == $ward->getId() ? 'selected' : ''?>><?=$ward->getName()?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" value="<?=$housenumber_street?>" class="form-control" placeholder="Địa chỉ" name="address" required="" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        <h4>Phương thức thanh toán</h4>
                        <div class="form-group">
                            <label> <input type="radio" name="payment_method" checked="" value="0"> Thanh toán khi giao hàng (COD) </label>
                            <div></div>
                        </div>
                        <div class="form-group">
                            <label> <input type="radio" name="payment_method" value="1"> Chuyển khoản qua ngân hàng </label>
                            <div class="bank-info">STK: 0421003707901<br>Chủ TK: Nguyễn Hữu Lộc. Ngân hàng: Vietcombank TP.HCM <br>
                                Ghi chú chuyển khoản là tên và chụp hình gửi lại cho shop dễ kiểm tra ạ
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm btn-primary pull-right">Hoàn tất đơn hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php include_once "layout/footer.php"; ?>