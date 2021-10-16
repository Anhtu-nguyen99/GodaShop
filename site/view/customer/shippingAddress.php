<?php include_once "layout/header.php"; ?>
        <main id="maincontent" class="page-main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-9">
                        <ol class="breadcrumb">
                            <li><a href="/" target="_self">Trang chủ</a></li>
                            <li><span>/</span></li>
                            <li class="active"><span>Tài khoản</span></li>
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                        <?php include_once "layout/sidebarMyAccount.php"; ?>
                    <div class="col-md-9 account">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4 class="home-title">Địa chỉ giao hàng mặc định</h4>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <form action="index.php?c=customer&amp;a=saveShippingAddress" method="POST" role="form">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="text" value="<?=$customer->getShippingName()?>" class="form-control" name="fullname" placeholder="Họ và tên" required="" oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <input type="tel" value="<?=$customer->getShippingMobile()?>" class="form-control" name="mobile" placeholder="Số điện thoại" required="" pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select name="province" class="form-control province" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')" oninput="this.setCustomValidity('')">
                                                <option value="">Tỉnh / thành phố</option>

                                                <?php foreach ($provinces as $province) {?>

                                                <option <?=$customer_province_id === $province->getId() ? 'selected' : ''?> value="<?=$province->getId()?>"><?=$province->getName()?></option>
                                                
                                               <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select name="district" class="form-control district" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
                                                <option value="">Quận / Huyện</option>
                                                <?php foreach ($districts as $district) {?>
                                                <option <?=$customer_district_id === $district->getId() ? 'selected' : ''?> value="<?=$district->getId()?>"><?=$district->getName()?></option>
                                                <?php }?>

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
                                                <option value="">Phường / xã</option>
                                                <?php foreach ($wards as $ward) {?>
                                                <option <?=$customer_ward_id === $ward->getId() ? 'selected' : ''?> value="<?=$ward->getId()?>"><?=$ward->getName()?></option>
                                                <?php }?>
                                                
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <input type="text" value="<?=$customer->getHousenumberStreet()?>" class="form-control" placeholder="Địa chỉ" name="housenumber_street" required="" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php include_once "layout/footer.php"; ?>