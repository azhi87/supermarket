
var i = 0;

function removeItem(id) {
    $("div").remove("#" + id);
    $("tr").remove("#" + id);
    getSaleTotalPrice();
    getPurchaseTotalPrice();
}

function addItem() {
    i = +document.getElementById("howManyItems").value;
    i++;
    var item = `<tr id="${i}">
              <td>
                <span class='badge badge-danger'>${i + 1}</span>
              </td>

              <td>
              <select id='barcode${i}' name='item[barcode][]' onchange='getPurchaseItemPrice(this.value,this.id)' onblur='getPurchaseItemPrice(this.value,this.id)' class='form-control select3'>
              </select>
              </td>

              <td>
              <input type='number' step='0.01' onkeyup='getPurchaseTotalPrice();'  onblur='getPurchaseTotalPrice();' name='item[ppi][]' id='ppi${i}' class='form-control '>
              </td>

              <td>
              <input type='number' step='250'  name='item[sppi][]' id='sppi${i}' class='form-control '>
              </td>
              <td>
              <input type='number' step='1' onkeyup='getPurchaseTotalPrice();'  onblur='getPurchaseTotalPrice();' value='1' id='quantity${i}'  name='item[quantity][]' class='form-control'>
              </td> 


              <td>
              <input type='number' step='1' onkeyup='getPurchaseTotalPrice();' value='0' required onblur='getPurchaseTotalPrice();' name='item[bonus][]' id='bonus${i}' class='form-control'>
              </td>

              <td> <span class = 'badge badge-primary' id='subtotal${i}'></span></td >
              <td>
              <input type='date' name='item[exp][]' id='exp${i}' class='form-control' required>
              </td> 
               <td class='hidden'>
              <input type='text' name='item[batch_no][]' id='batch_no${i}' class='form-control'>
              </td> 
              <td>
              <button class='btn btn-danger btn-circle btn3d' type='button'  onclick='removeItem(${i})'>
              <i caption='delete' class='fa fa-minus-circle fa-1x'></i></button></td> 
              </tr>`;

    $(".select3").select2();
    document.getElementById("howManyItems").value = i;
    $("#repeatedSale").append(item);
    $(".select3").select2({
        width: "100%",
        allowClear: true,
        multiple: true,
        maximumSelectionSize: 1,
        ajax: {
            url: "/drugs/searchAjax",
            type: "post",
            dataType: "json",
            data: function (params) {
                return {
                    _token: CSRF_TOKEN,
                    search: params.term, // search term
                };
            },
            processResults: function (response) {
                if (response.length == 1) {
                    $("#barcode" + i)
                        .append(
                            $("<option />")
                                .attr("value", response[0].id)
                                .html(response[0].text)
                        )
                        .val(response[0].id)
                        .trigger("change")
                        .select2("close");
                }
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
    $("#barcode" + i).select2("open");
    $("#barcode" + i).select2("open");
    document.getElementById("howManyItems").value = i;
}

function addSaleItem(id,name,ppi,items_per_box) {
    i = document.getElementById("howManyItems").value;
    i++;
    var item = `<tr id='${i}'>

    <td>
    <span class='badge badge-danger'>${i + 1}</span>
    </td>
    <td>
    <input type='hidden' id='barcode${i}' name='item[barcode][]' value='${id}' class='form-control'>
    <input  type='text' value='${name}' class='form-control' readonly>
    </td>
    <td>
    <input type='number' value="${ppi}" step='250' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' name='item[ppi][]' id='ppi${i}' class='form-control '>
    </td>

    <td>
    <input type='number' step='1' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' value='1' id='quantity${i}'  name='item[quantity][]' class='form-control '>
    </td>

    <td>
    <input type='number' step='0' id='singles${i}' name='item[singles][]'  onkeyup='getSaleTotalPrice();' onblur='getSaleTotalPrice();' value='0'  class='form-control'>
    </td>

    <td class='hidden'>
    <span name='item[items_per_box][]' id='items_per_box${i}' class='badge badge-primary'></span>
    </td>

    <td>
    <span class='badge badge-primary' id='subtotal${i}'></span>
    </td>

    <td class='hidden'>
    <select name='item[exp][]' id='exp${i}' class='form-control '><select>
    <input type='text' value='' name='item[batch_no][]' id='batch_no${i}'>
    </td>

    <td>
   <button class='btn btn-danger btn-circle btn3d' type='button'  onclick='removeItem(${i})'>
    <i caption='delete' class='fa fa-minus-circle fa-1x'></i></button>
    </td>
    </tr>`;

    document.getElementById("howManyItems").value = i;
    $("#repeatedSale").append(item);
    $('#barcode').val(null).trigger('change');
}

function getItemPrice(barcode, id) {
    var index = id.match(/\d+$/),
        number;
    index = index[0];
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/purchases/ItemPrice",
        data: "barcode=" + barcode,
        success: function (data) {
            $("#name" + index).attr("value", data.name);
            $("#ppi" + index).attr("value", data.price);

            //alert("price: " + data.price + "\nName: " + data.name);

            getSaleTotalPrice();
        },
        error: function () {
            $("#ppi" + index).attr("value", 0);
            $("#name" + index).attr("value", "Wrong code");
        },
    });
}

function getPurchaseItemPrice(barcode, id) {
    var index = id.match(/\d+$/),
        number;
    index = index[0];
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/purchases/ItemPurchasePrice",
        data: "barcode=" + barcode,
        success: function (data) {
            $("#ppi" + index).attr("value", data.price);
            $("#sppi" + index).attr("value", data.sale_price);
            $("#name" + index).text(data.name);
            getPurchaseTotalPrice();
            addItem();
        },
        error: function () {
            $("#ppi" + index).attr("value", 0);
            $("#name" + index).attr("value", "Wrong barcode");
        },
    });
}

function getSaleTotalPrice() {
    var total = 0;
    var ppi = 0;
    var quantity = 0;
    var singles = 0;
    var items_per_box = 0;
    var discount = $("#discount").val();
    i = parseInt($("#howManyItems").val());
    for (j = 0; j <= i; j++) {
        if ($("#ppi" + j).val() && $("#quantity" + j).val()) {
            ppi = $("#ppi" + j).val();
            quantity = $("#quantity" + j).val();
            singles = $("#singles" + j).val();
            let stock = $("#exp" + j)
                .find(":selected")
                .attr("data-stock");
            items_per_box = $("#items_per_box" + j).text();
            let total_quantity = +singles / +items_per_box + +quantity;
            if (total_quantity > stock) {
                swal({
                    text: "The quantity you entered is not available in stock",
                    type: "error",
                    title: "Stock violation",
                    confirmButtonClass: "btn btn-success btn-fill",
                    buttonsStyling: false,
                });
                $("#singles" + j).val(0);
                $("#quantity" + j).val(stock);
            }

            subtotal = Math.round(ppi * total_quantity);
            if (subtotal % 250 !== 0) {
                subtotal = 250 - (subtotal % 250) + subtotal;
            }
            $("#subtotal" + j).text(subtotal);
            total = total + +subtotal;
        }
    }
    $("#grandTotal").attr("value", total - discount);
    $("#total").attr("value", total);
}

function getPurchaseTotalPrice() {
    var total = 0;
    var ppi = 0;
    var quantity = 0;
    let subtotal = 0;
    i = parseInt($("#howManyItems").val());
    for (j = 0; j <= i; j++) {
        if ($("#ppi" + j).val() && $("#quantity" + j).val()) {
            ppi = $("#ppi" + j).val();
            quantity = $("#quantity" + j).val();
            subtotal = +ppi * +quantity;
            total += subtotal;
            $("#subtotal" + j).text(subtotal.toFixed(2));
        }
    }

    $("#total").attr("value", total.toFixed(2)); //only for purchase
}

//  $("#saleForm").bind("keypress", function (e) {
//    if (e.keyCode == 13) {
//       //  addSaleItem();
//       //  return false;
//    }});

function getSaleItemPrice(barcode) {
    let name, ppi, items_per_box;
    if (!barcode) {
        return false;
   }
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/purchases/ItemPrice",
        data: "barcode=" + barcode,
        success: function (data) {
            ppi = data.price;
            name = data.name;
            items_per_box = data.items_per_box;
            getSaleTotalPrice();
            addSaleItem(barcode,name,ppi,items_per_box);
        },
        error: function (data) {
            alert('server error');
        },
    });
}

function printExternal(url) {
    var printWindow = window.open(
        url,
        "Print",
        "left=200, top=200, width=950, height=500, toolbar=0, resizable=0"
    );
    printWindow.addEventListener(
        "load",
        function () {
            printWindow.print();
            printWindow.close();
        },
        true
    );
}

function confirmDelete(id) {
    $("#delete").attr("href", "/purchase/delete/" + id);
    $("#myModal").modal("show");
}

function confirmDeleteSale(id) {
    $("#delete").attr("href", "/sale/delete/" + id);
    $("#myModal").modal("show");
}
