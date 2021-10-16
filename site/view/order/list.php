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
                    <div class="col-md-9 order">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4 class="home-title">Đơn hàng của tôi</h4>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <!-- Mỗi đơn hàng -->
                                <?php foreach ($orders as $order) {?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Đơn hàng <a href="index.php?c=order&a=detail&id=<?=$order->getId()?>">#<?=$order->getId()?></a></h5>
                                        <span class="date">
                                        Đặt hàng <?=$order->getCreatedDate()?>                                </span>
                                        <hr>
                                        <?php foreach ($order->getOrderItems() as $orderItem) {?>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="../upload/<?=$orderItem->getProduct()->getFeaturedImage()?>" alt="" class="img-responsive">
                                            </div>
                                            <div class="col-md-3">
                                                <a class="product-name" href="index.php?c=product&a=detail&id=<?=$orderItem->getProduct()->getId()?>"><?=$orderItem->getProduct()->getName()?></a>
                                            </div>
                                            <div class="col-md-2">
                                                Số lượng:<?=$orderItem->getQty()?>                                   
                                            </div>
                                            <div class="col-md-2">
                                                <?=$order->getStatus()->getDescription()?>                                    
                                            </div>
                                            <div class="col-md-3">
                                                Giao hàng ngày <?=$order->getDeliveredDate()?>                
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- FOOTER -->
<?php include_once "layout/footer.php"; ?>        