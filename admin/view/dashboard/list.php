<?php $page_title = "Tổng quan"?>
<?php include_once "layout/header.php"?>
<div class="container-fluid">
   <!-- Breadcrumbs-->
   <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tổng quan</li>
   </ol>
   <div class="mb-3 my-3">
      <a href="#" class="active btn btn-primary">Hôm nay</a>
      <a href="#" class="btn btn-primary">Hôm qua</a>
      <a href="#" class="btn btn-primary">Tuần này</a>
      <a href="#" class="btn btn-primary">Tháng này</a>
      <a href="#" class="btn btn-primary">3 tháng</a>
      <a href="#" class="btn btn-primary">Năm này</a>
      <div class="dropdown" style="display:inline-block">
         <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <div style="margin:20px">
               Từ ngày <input type="date" class="form-control" id="usr">
               Đến ngày <input type="date" class="form-control" id="usr">
               <br>
               <input type="submit" value="Tìm" class="btn btn-primary form-control">
            </div>
         </div>
      </div>
   </div>
   <!-- Icon Cards-->
   <div class="row">
      <div class="col-xl-4 col-sm-6 mb-3">
         <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
               </div>
               <div class="mr-5"><?=count($orders)?> Đơn hàng</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
               <span class="float-left">Chi tiết</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>
      <div class="col-xl-4 col-sm-6 mb-3">
         <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
               </div>
               <?php 
               $revenue = 0;
               $canceledOrders = [];
               foreach ($orders as $order) {
                  $orderItems = $order->getOrderItems();
                  if ($order->getStatus()->getName() == "canceled") {
                     $canceledOrders[] = $order;
                  }
                  else {
                     foreach ($orderItems as $orderItem) {
                        $revenue += $orderItem->getTotalPrice();
                     }
                     $revenue += $order->getShippingFee();
                  }
               }

               ?>
               <div class="mr-5">Doanh thu <?=number_format($revenue)?> đ</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
               <span class="float-left">Chi tiết</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>
      <div class="col-xl-4 col-sm-6 mb-3">
         <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
               </div>
               <div class="mr-5"><?=count($canceledOrders)?> đơn hàng bị hủy</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
               <span class="float-left">Chi tiết</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>
   </div>
   <!-- DataTables Example -->
   <div class="card mb-3">
      <div class="card-header">
         <i class="fas fa-table"></i>
         Đơn hàng
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <?php include_once "layout/orderList.php" ?>
         </div>
      </div>
   </div>
</div>
   <!-- /.container-fluid -->
<?php include_once "layout/footer.php" ?>