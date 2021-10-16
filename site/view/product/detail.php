<?php include_once "layout/header.php"; ?>
        <main id="maincontent" class="page-main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-9">
                        <ol class="breadcrumb">
                            <li><a href="/" target="_self">Trang chủ</a></li>
                            <li><span>/</span></li>
                            <li class="active"><span>Kem Dưỡng Da</span></li>
                        </ol>
                    </div>
                    <div class="col-xs-3 hidden-lg hidden-md">
                        <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
                    </div>
                    <div class="clearfix"></div>
                    <?php include "layout/sidebar.php"; ?>
                    <div class="col-md-9 product-detail">
                        <div class="row product-info">
                            <div class="col-md-6">
                                <img data-zoom-image="../upload/<?=$product->getFeaturedImage()?>" class="img-responsive thumbnail main-image-thumbnail" src="../upload/<?=$product->getFeaturedImage()?>" alt="">
                                <div class="product-detail-carousel-slider">
                                    <div class="owl-carousel owl-theme">
                                        <div class="item thumbnail"><img src="../upload/<?=$product->getFeaturedImage()?>" alt=""></div>
                                        <?php foreach ($product->getImageItems() as $itemImage) { ?>
                                        <div class="item thumbnail"><img src="../upload/<?=$itemImage->getName()?>" alt=""></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="product-name"><?=$product->getName()?></h5>
                                <div class="brand">
                                    <span>Nhãn hàng: </span> <span><?=$product->getBrand()->getName()?></span> 
                                </div>
                                <div class="product-status"> 
                                    <span>Trạng thái: </span>
                                    <?php if ($product->getInventoryQty() == 0) { ?>
                                    <span class="label-warning">Hết hàng</span>
                                    <?php } else { ?>
                                    <span class="label-warning">Còn hàng</span>
                                    <?php } ?>
                                </div>
                                <div class="product-item-price">
                                    <span>Giá: </span>
                                    <span class="product-item-discount"><?=number_format($product->getSalePrice()) ?> d</span>        
                                </div>
                                <?php if ($product->getInventoryQty() > 0) { ?>
                                <div class="input-group">
                                    <input type="number" class="product-quantity form-control" value="1" min="1" product="5178">
                                    
                                    <a href="javascript:void(0)" product-id="<?=$product->getId()?>" class="buy-in-detail btn btn-success cart-add-button"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row product-description">
                            <div class="col-xs-12">
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#product-description" aria-controls="home" role="tab" data-toggle="tab">Mô tả</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#product-comment" aria-controls="tab" role="tab" data-toggle="tab">Đánh giá</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="product-description">   
                                        <?=$product->getDescription()?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="product-comment">
                                            <form class="form-comment" action="index.php?c=comment&a=save" method="POST" role="form">
                                                <label>Đánh giá của bạn</label>
                                                <div class="form-group">
                                                    <input type="hidden" name="product_id" value="<?=$product->getId()?>">
                                                    <input class="rating-input" name="star" type="text" title="" value="4"/>
                                                    <input type="text" class="form-control" id="" name="fullname" placeholder="Tên *" required>
                                                    <input type="email" name="email" class="form-control" id="" placeholder="Email *" required>
                                                    <textarea name="description" id="input" class="form-control" rows="3" required placeholder="Nội dung *"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Gửi</button>
                                            </form>
                                            <div class="comment-list">
                                                <?php include "view/product/commentList.php"; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-related equal">
                            <div class="col-md-12">
                                <h4 class="text-center">Sản phẩm liên quan</h4>
                                <div class="owl-carousel owl-theme">
                                    <?php foreach ($relatedProducts as $product) { ?>
                                    <div class="item thumbnail">
                                    <?php include "layout/product.php"; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php include_once "layout/footer.php"; ?>