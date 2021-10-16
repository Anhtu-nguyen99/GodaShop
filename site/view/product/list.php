<?php include_once "layout/header.php"; ?>
        <main id="maincontent" class="page-main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-9">
                        <ol class="breadcrumb">
                            <li><a href="/" target="_self">Trang chủ</a></li>
                            <li><span>/</span></li>
                            <li class="active"><span>Tất cả sản phẩm</span></li>
                        </ol>
                    </div>
                    <div class="col-xs-3 hidden-lg hidden-md">
                        <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
                    </div>
                    <div class="clearfix"></div>
                    <?php include "layout/sidebar.php"?>
                    <div class="col-md-9 products">
                        <div class="row equal">
                            <div class="col-xs-6">
                                <h4 class="home-title">Tất cả sản phẩm</h4>
                            </div>
                            <div class="col-xs-6 sort-by">
                                <div class="pull-right">
                                    <label class="left hidden-xs" for="sort-select">Sắp xếp: </label>
                                    <select id="sort-select">
                                        <option <?=empty($selected_sort) ? "selected" : "" ?> value="" >Mặc định</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="price-asc" ? "selected" : "" ?> value="price-asc">Giá tăng dần</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="price-desc" ? "selected" : "" ?> value="price-desc">Giá giảm dần</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="alpha-asc" ? "selected" : "" ?> value="alpha-asc">Từ A-Z</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="alpha-desc" ? "selected" : "" ?> value="alpha-desc">Từ Z-A</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="created-asc" ? "selected" : "" ?> value="created-asc">Cũ đến mới</option>
                                        <option <?=!empty($selected_sort) && $selected_sort=="created-desc" ? "selected" : "" ?> value="created-desc">Mới đến cũ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($products as $product) {

                            ?>
                            <div class="col-xs-6 col-sm-4">
                                <?php include "layout/product.php"?>
                            </div>
                        <?php } ?>
                        </div>
                        <!-- Paging -->
                <ul class="pagination pull-right">
                    <?php if ($selected_page > 1) {?>
                    <li><a href="javascript:void(0)" onclick="goToPage(<?=$selected_page-1?>)">&laquo;</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $page_total; $i++) { ?>
                    <li class="<?=$selected_page==$i ? 'active' : ''?>"><a href="javascript:void(0)" onclick="goToPage(<?=$i?>)"><?=$i?></a></li>
                    <?php } ?>
                    <?php if ($selected_page < $page_total) {?>
                    <li><a href="javascript:void(0)" onclick="goToPage(<?=$selected_page+1?>)">&raquo;</a></li>
                    <?php } ?>
                </ul>
                <!-- End paging -->
                    </div>
                </div>
            </div>
        </main>
<?php include_once "layout/footer.php"; ?>