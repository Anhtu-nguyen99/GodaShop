function openMenuMobile() {
    $(".menu-mb").width("250px");
    $(".btn-menu-mb").hide("slow");
}

function closeMenuMobile() {
    $(".menu-mb").width(0);
    $(".btn-menu-mb").show("slow");
}

$(function () {
    // Thay đổi province
    $("main .province").change(function(event) {
        var province_id = $(this).val();
        if (!province_id) {
            updateSelectBox(null, "main .district");
            updateSelectBox(null, "main .ward");
            return;
        }

        $.ajax({
            url: 'index.php?c=address&a=getDistricts',
            type: 'GET',
            data: {province_id: province_id}
        })
        .done(function(data) {
            updateSelectBox(data, "main .district");
            updateSelectBox(null, "main .ward");
        });

        if ($("main .shipping-fee").length) {
            $.ajax({
                url: 'index.php?c=address&a=getShippingFee',
                type: 'GET',
                data: {province_id: province_id}
            })
            .done(function(data) {
                //update shipping fee and total on UI
                let shipping_fee = Number(data);
                let payment_total = Number($("main .payment-total").attr("data")) + shipping_fee;

                $("main .shipping-fee").html(number_format(shipping_fee) + "₫");
                $("main .payment-total").html(number_format(payment_total) + "₫");
            });
        }

        
    });

    // Thay đổi district
    $("main .district").change(function(event) {
        var district_id = $(this).val();
        if (!district_id) {
            updateSelectBox(null, "main .ward");
            return;
        }

        $.ajax({
            url: 'index.php?c=address&a=getWards',
            type: 'GET',
            data: {district_id: district_id}
        })
        .done(function(data) {
            updateSelectBox(data, "main .ward");
        });
    });

    // // Tiếp tục mua sắm
    // $('input[name=back-shopping]').click(function(event) {
    //     window.location = "index.php?c=product&a=list";
    // });

     // Thêm sản phẩm vào giỏ hàng
    $("main .buy-in-detail").click(function(event) {
        var qty = $(this).prev("input").val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: 'index.php?c=cart&a=update',
            type: 'GET',
            data: {product_id: product_id, qty: qty, more: 1}
        })
        .done(function(data) {
            displayCart(data);
            
        });
    });
    // Load paging
    $.ajax({
        url: 'index.php?c=cart&a=display',
        type: 'GET'
    })
    .done(function(data) {
        displayCart(data);
        
    });
    // Thêm sản phẩm vào giỏ hàng
    $("main .buy").click(function (event) {
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: 'index.php?c=cart&a=add',
            type: 'GET',
            data: { product_id: product_id, qty: 1 }
        })
            .done(function (data) {
                displayCart(data);
                // alert(data);
            });
    });

    // Ajax search
    var timeout = null;
    $("header form.header-form .search").keyup(function (event) {
        // alert(pattern);
        clearTimeout(timeout);
        var pattern = $(this).val();
        $(".search-result").html("");
        timeout = setTimeout(function () {
            if (pattern) {
                $.ajax({
                    url: 'index.php?c=product&a=ajaxSearch',
                    type: 'GET',
                    data: { pattern: pattern },
                })
                    .done(function (data) {
                        $(".search-result").html(data);
                        $(".search-result").show();

                    });
            }

        }, 700);

    });
    // Submit đánh giá sản phẩm
    $("form.form-comment").submit(function (event) {
        event.preventDefault(); //prevent default action
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        })
            .done(function (data) {
                $(".comment-list").html(data);
                updateAnsweredRating();
            });
    });
    // Tìm kiếm và sắp xếp sản phẩm
    $('#sort-select').change(function (event) {
        var str_param = getUpdatedParam("sort", $(this).val());
        window.location.href = "index.php?" + str_param;
    });
    // Tìm kiếm theo range
    $('main .price-range input').click(function (event) {
        var price_range = $(this).val();
        window.location.href = "index.php?c=product&price-range=" + price_range;
    });
    $(".product-container").hover(function () {
        $(this).children(".button-product-action").toggle(400);
    });

    // Display or hidden button back to top
    $(window).scroll(function () {
        if ($(this).scrollTop()) {
            $(".back-to-top").fadeIn();
        }
        else {
            $(".back-to-top").fadeOut();
        }
    });

    // Khi click vào button back to top, sẽ cuộn lên đầu trang web trong vòng 0.8s
    $(".back-to-top").click(function () {
        $("html").animate({ scrollTop: 0 }, 800);
    });

    // Hiển thị form đăng ký
    $('.btn-register').click(function () {
        $('#modal-login').modal('hide');
        $('#modal-register').modal('show');
    });

    // Hiển thị form forgot password
    $('.btn-forgot-password').click(function () {
        $('#modal-login').modal('hide');
        $('#modal-forgot-password').modal('show');
    });

    // Hiển thị form đăng nhập
    $('.btn-login').click(function () {
        $('#modal-login').modal('show');
    });

    // Fix add padding-right 17px to body after close modal
    // Don't rememeber also attach with fix css
    $('.modal').on('hide.bs.modal', function (e) {
        e.stopPropagation();
        $("body").css("padding-right", 0);

    });

    // Hiển thị cart dialog
    $('.btn-cart-detail').click(function () {
        $('#modal-cart-detail').modal('show');
    });

    // Hiển thị aside menu mobile
    $('.btn-aside-mobile').click(function () {
        $("main aside .inner-aside").toggle();
    });

    // Hiển thị carousel for product thumnail
    $('main .product-detail .product-detail-carousel-slider .owl-carousel').owlCarousel({
        margin: 10,
        nav: true
    });
    // Bị lỗi hover ở bộ lọc (mobile) & tạo thanh cuộn ngang
    // Khởi tạo zoom khi di chuyển chuột lên hình ở trang chi tiết
    // $('main .product-detail .main-image-thumbnail').ezPlus({
    //     zoomType: 'inner',
    //     cursor: 'crosshair',
    //     responsive: true
    // });

    // Cập nhật hình chính khi click vào thumbnail hình ở slider
    $('main .product-detail .product-detail-carousel-slider img').click(function (event) {
        /* Act on the event */
        $('main .product-detail .main-image-thumbnail').attr("src", $(this).attr("src"));
        var image_path = $('main .product-detail .main-image-thumbnail').attr("src");
        $(".zoomWindow").css("background-image", "url('" + image_path + "')");

    });

    $('main .product-detail .product-description .rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false
    });

    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });

    $('main .ship-checkout[name=payment_method]').click(function (event) {
        /* Act on the event */
    });

    $('input[name=checkout]').click(function (event) {
        /* Act on the event */
        window.location.href = "index.php?c=payment&a=checkout";
    });

    $('input[name=back-shopping]').click(function (event) {
        /* Act on the event */
        window.location.href = "index.php?c=product&a=list";
    });

    // Hiển thị carousel for relative products
    $('main .product-detail .product-related .owl-carousel').owlCarousel({
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }

    });
});

// Login in google
function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://study.com/register/google/backend/process.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);
}
// Paging
function goToPage(page) {
    var str_param = getUpdatedParam("page", page);
    window.location.href = "index.php?" + str_param;
}
// Cập nhật giá trị của 1 param cụ thể
function getUpdatedParam($param, $value) {
    var params = {};
    window.location.search
        .replace(/[?&]+([^=&]+)=([^&]*)/gi, function (str, key, value) {
            params[key] = value;
        }
        );
    params[$param] = $value;

    var x = [];
    for (p in params) {
        x.push(p + "=" + params[p]);
    }
    return str_param = x.join("&");
}
// Hiển thị những rating của những đánh giá
function updateAnsweredRating() {
    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });
}

// Cập nhật giỏ hàng
function displayCart(data) {
    var cart = JSON.parse(data);
    console.log(cart);

    var total_product_number = cart.total_product_number;
    $(".number-total-product").html(total_product_number);
    
    var total_price = cart.total_price;
    $(".price-total").html(number_format(Math.round(total_price)) + 'đ');

    var rows = "";
    var items = cart.items;
    for (let product_id in items) {
        var item = items[product_id];
        var row =   '<hr>' +
                    '<div class="clearfix text-left">' +
                        '<div class="row">' +
                            '<div class="col-sm-6 col-md-1">' +
                                '<div><img class="img-responsive" src="../upload/'+ item.img +'" alt="'+ item.name +'"></div>' +
                            '</div>' +
                            '<div class="col-sm-6 col-md-3"><a class="product-name" href="index.php?c=product&a=detail&id='+ item.product_id +'">'+ item.name +'</a></div>' +
                            '<div class="col-sm-6 col-md-2"><span class="product-item-discount">'+ number_format(Math.round(item.unit_price)) + 'đ' +'</span></div>' +
                            '<div class="col-sm-6 col-md-3"><input type="hidden" value="1"><input type="number" onchange="updateProductInCart(this,'+ item.product_id +')" min="1" value="'+ item.qty +'"></div>' +
                            '<div class="col-sm-6 col-md-2"><span>'+ number_format(Math.round(item.total_price)) + 'đ' +'</span></div>' +
                            '<div class="col-sm-6 col-md-1"><a class="remove-product" href="javascript:void(0)" onclick="deleteProductInCart('+ item.product_id +')"><span class="glyphicon glyphicon-trash"></span></a></div>' +
                        '</div>' +
                    '</div>';
        rows += row;
    }
    $(".cart-product").html(rows);
}

// Delete sản phẩm trong giỏ hàng
function deleteProductInCart(product_id) {
    $.ajax({
        url: 'index.php?c=cart&a=delete',
        type: 'GET',
        data: {product_id: product_id}
    })
    .done(function(data) {
        displayCart(data);
        
    });
}

// Thay đổi số lượng sản phẩm trong giỏ hàng
function updateProductInCart(self, product_id) {
    var qty = $(self).val();
    $.ajax({
        url: 'index.php?c=cart&a=update',
        type: 'GET',
        data: {product_id: product_id, qty: qty}
    })
    .done(function(data) {
        displayCart(data);
        
    });
}

// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector) {
    var items = JSON.parse(data);
    $(selector).find('option').not(':first').remove();
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let option = '<option value="' + item.id + '"> ' + item.name + '</option>';
        $(selector).append(option);
    }
    
}


// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector) {
    var items = JSON.parse(data);
    $(selector).find('option').not(':first').remove();
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let option = '<option value="' + item.id + '"> ' + item.name + '</option>';
        $(selector).append(option);
    }
    
}
