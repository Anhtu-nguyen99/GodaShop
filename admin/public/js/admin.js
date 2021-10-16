function checkAll(check_all) {
	$(check_all).change(function() {
	    var checkboxes = $(this).closest('table').find(':checkbox');
	    checkboxes.prop('checked', $(this).is(':checked'));
	});
}
$(function(){

    $('.comment-list .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'xs',
        stars: "5",
        showClear: false,
        showCaption: false
    });
    // Display error if exist error
    if ($('#errorModal .modal-title').html().trim()) {
        $('#errorModal').modal('show'); 
    }

    // Display error if exist error
    if ($('#infoModal .modal-title').html().trim()) {
        $('#infoModal').modal('show'); 
    }
    
    
    var table = $('#dataTable').DataTable();
    $('form').on('submit', function(e){
      var form = this;
      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input').serializeArray();
      // Iterate over all form elements
      $.each(params, function(){
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element

            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name + "[]")
                  .val(this.value)
            );
         }
      });
   });

    //Tìm sản phẩm dựa trên barcode
    var timeout = null;
    $("#search-barcode").keyup(function(event) {
        clearTimeout(timeout);
        /* Act on the event */
        var self = this;
        var barcode = $(this).val();

        // only support barcode EAN13
        if (barcode.length != 13) return;
        timeout = setTimeout(function(){
            $.ajax({
                url: 'index.php?c=product&a=ajaxFind',
                type: 'GET',
                data: {barcode: barcode},
            })
            .done(function(data) {
                if (data) {
                    item = JSON.parse(data);
                    if (hasUpdateQty(item.id, "table.product-item", "product-id")) {
                        $(self).val("");
                        return;
                    }
                    var tr = '<tr>'+
                        
                          '<td >' + item.barcode + 
                            ' <input type="hidden" name="product-id" value="' + item.id + '">'+
                            ' <input type="hidden" name="product_ids[]" value="' + item.id + '">'+
                            '</td>'+
                          '<td> ' + item.name + ' </td>'+
                          '<td><img src="../upload/' + item.featured_image + '"></td>';
                    //Chỉ hiển thị giảm giá và giá gốc nếu giá gốc và giá bán khác nhau
                    if (item.sale_price != item.price) {
                        tr += '<td>' + number_format(item.sale_price) + 'đ <del>' + number_format(item.price) + 'đ (' + item.discount_percentage + '%)</del></td>';
                    }
                    else {
                        tr += '<td>' + number_format(item.sale_price) + 'đ</td>';
                    }
                          
                    tr += '<td><input name="qties[]" data-sale-price="' + item.sale_price + '" class="order-item-qty" type="number" min="1" value="1" /></td>'+
                          '<td><span class="order-item-money" data="' + item.sale_price + '">' + number_format(item.sale_price) + 'đ</span></td>'+
                          '<td><i class="fas fa-times order-item-delete"></i></td>'+
                       '</tr>';

                    $("table.product-item tbody").append(tr);
                    updateSubTotal();

                    //Xóa chỗ nhập barcode, để người dùng nhập vào cái mới
                    $(self).val("");

                    $("table.product-item tbody .order-item-qty").change(function(event) {
                        /* Act on the event */
                        var order_item_money =  Number($(this).val()) * Number($(this).attr("data-sale-price"));
                        $(this).closest('tr').find(".order-item-money").html(number_format(order_item_money) + "đ");
                        $(this).closest('tr').find(".order-item-money").attr("data", order_item_money);
                        updateSubTotal();
                    });

                    //Delete product on order
                    $("table.product-item tbody .order-item-delete").click(function(event) {
                        /* Act on the event */
                        $(this).closest('tr').remove();
                        updateSubTotal();
                    });
                }
            });
        },100);
    });

    //Remove event enter on search barcode
    $('#search-barcode').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });
    
    //Thay đổi khách hàng
    
    $(".chosen-customer").change(function(event) {
        /* Act on the event */
        var customer_id = $(this).val();
        
        //Reset
        updateSelectBox(null, ".province");
        updateSelectBox(null, ".district");
        updateSelectBox(null, ".ward");
        $(".shipping-mobile").val("");
        $(".shipping-name").val("");
        $(".shipping-fee").val(0);
        resetShippingFee();
        $(".housenumber_street").val("");
        if (!customer_id) return;
        $.ajax({
            url: 'index.php?c=order&a=ajaxGetShippingInfoDefault',
            type: 'GET',
            data: {customer_id: customer_id}
        })
        .done(function(data) {
            data = JSON.parse(data);
            updateSelectBox(JSON.stringify(data.provinces) , ".province", data.selected_province_id);
            updateSelectBox(JSON.stringify(data.districts), ".district", data.selected_district_id);
            updateSelectBox(JSON.stringify(data.wards), ".ward", data.selected_ward_id);
            $(".shipping-mobile").val(data.shipping_mobile);
            $(".shipping-name").val(data.shipping_name);
            $(".housenumber_street").val(data.housenumber_street);
            if (data.selected_province_id) {
                updateShippingFee(data.selected_province_id);
            }
            
        });
    });

    // Thay đổi province
    $(".province").change(function(event) {
        /* Act on the event */
        var province_id = $(this).val();
        if (!province_id) {
            updateSelectBox(null, ".district");
            updateSelectBox(null, ".ward");
            return;
        }

        $.ajax({
            url: 'index.php?c=address&a=getDistricts',
            type: 'GET',
            data: {province_id: province_id}
        })
        .done(function(data) {
            updateSelectBox(data, ".district");
            updateSelectBox(null, ".ward");
        });

        if ($(".shipping-fee").length) {
            updateShippingFee(province_id);
        }

        
    });

    // Thay đổi district
    $(".district").change(function(event) {
        /* Act on the event */
        var district_id = $(this).val();
        if (!district_id) {
            updateSelectBox(null, ".ward");
            return;
        }

        $.ajax({
            url: 'index.php?c=address&a=getWards',
            type: 'GET',
            data: {district_id: district_id}
        })
        .done(function(data) {
            updateSelectBox(data, ".ward");
        });
    });

    $(".shipping-fee").change(function(event) {
    	let shipping_fee = Number($(this).val());
        let payment_total = Number($(".sub-total").attr("data")) + shipping_fee;

        $(".payment-total").html(number_format(payment_total) + "₫");
    });



 });

// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector, selected_id) {
    var items = JSON.parse(data);
    $(selector).find('option').not(':first').remove();
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let selected = "";
        if (selected_id == item.id) {
            selected = " selected ";
        }
        let option = '<option ' + selected + 'value="' + item.id + '"> ' + item.name + '</option>';
        $(selector).append(option);
    }
    
}

function hasUpdateQty(id, table, input_name) {
    var productInputs = $(table).find("input[name="+ input_name + "]");
    if (productInputs.length == 0) return false;
    for(let i = 0; i < productInputs.length; i++) {
        if ($(productInputs[i]).val() == id) {
            self = productInputs[i];
            var qty = Number($(self).closest('tr').find(".order-item-qty").val());
            var unit_price = Number($(self).closest('tr').find(".order-item-qty").attr("data-sale-price"));
            qty++;
            $(self).closest('tr').find(".order-item-qty").val(qty);
            var order_item_money =  qty * unit_price;
            $(self).closest('tr').find(".order-item-money").html(number_format(order_item_money) + "đ");
            $(self).closest('tr').find(".order-item-money").attr("data", order_item_money);
            updateSubTotal();
            return true;
        }
    }
    return false;
}

function updateSubTotal() {
    var table = ".product-item";
    var productInputs = $(table).find(".order-item-money");
    var sub_total = 0;
    for(let i = 0; i < productInputs.length; i++) {
        sub_total += Number($(productInputs[i]).attr("data"));
    }
    $(".sub-total").html(number_format(sub_total) + "đ");
    $(".sub-total").attr("data", sub_total);
    $(".payment-total").html(number_format(sub_total + Number($(".shipping-fee").val())) + "đ");
}

function resetShippingFee() {
    let sub_total = Number($(".sub-total").attr("data"));
    $(".payment-total").html(number_format(sub_total) + "₫");
}

function updateShippingFee(province_id) {
    
    $.ajax({
        url: 'index.php?c=address&a=getShippingFee',
        type: 'GET',
        data: {province_id: province_id}
    })
    .done(function(data) {
        //update shipping fee and total on UI
        let shipping_fee = Number(data);
        let payment_total = Number($(".sub-total").attr("data")) + shipping_fee;

        $(".shipping-fee").val(shipping_fee);
        $(".payment-total").html(number_format(payment_total) + "₫");
    });

}

// function printArea(area) {
//     window.print();
    // x = window.self;
    // console.log(window);
    // w = window.open(x.document.location);
    // w.alert("a");
    // w.document.getElementsByClass(".sidebar");
    
    // w.document.head.innerHTML = x.document.head.innerHTML;
    // w.document.body.innerHTML = x.document.body.innerHTML;
    // w = x;
    // w.document.write($(area).html());
    // w.document.body.innerHTML = $(area).html();
    // console.log(x);
    // w.print();
    // w.close();
// }