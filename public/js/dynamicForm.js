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
               <td>
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

function addSaleItem() {
    i = document.getElementById("howManyItems").value;
    i++;
    var item = `<tr id='${i}'>

    <td>
    <span class='badge badge-danger'>${i + 1}</span>
    </td>
    <td>
    <select id='barcode${i}' name='barcode[]' onchange='getSaleItemPrice(this.value,this.id)' onblur='getSaleItemPrice(this.value,this.id)' class='form-control select3'>
    </select>
    </td>

    <td>
    <input type='number' step='250' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' name='ppi[]' id='ppi${i}' class='form-control '>
    </td>

    <td>
    <input type='number' step='1' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' value='1' id='quantity${i}'  name='quantity[]' class='form-control '>
    </td>

    <td>
    <input type='number' step='0' id='singles${i}' name='singles[]'  onkeyup='getSaleTotalPrice();' onblur='getSaleTotalPrice();' value='0'  class='form-control'>
    </td>

    <td>
    <span name='items_per_box[]' id='items_per_box${i}' class='badge badge-primary'></span>
    </td>

    <td>
    <span class='badge badge-primary' id='subtotal${i}'></span>
    </td>

    <td>
    <select name='exp[]' id='exp${i}' class='form-control '><select>
    <input type='text' value='' name='batch_no[]' id='batch_no${i}' class='hidden'>
    </td>

    <td>
   <button class='btn btn-danger btn-circle btn3d' type='button'  onclick='removeItem(${i})'>
    <i caption='delete' class='fa fa-minus-circle fa-1x'></i></button>
    </td>
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

    // $(".table-fixed").freezeTable();
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

function getSaleItemPrice(barcode, id) {
    var index = id.match(/\d+$/),
        number;
    index = index[0];
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/purchases/ItemPrice",
        data: "barcode=" + barcode,
        success: function (data) {
            $("#ppi" + index).attr("value", data.price);
            $("#name" + index).text(data.name);
            $("#items_per_box" + index).text(data.items_per_box);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/purchase/getExpiryDates",
                data: "barcode=" + barcode,
                success: function (data2) {
                    if (data2.length === 0) {
                        swal("This item is not available in stock");
                        $("barcode" + index).val("");
                        $("barcode" + index).trigger("change");
                        $("#exp" + index).empty();
                        return false;
                    }
                    $("#exp" + index).empty();
                    $.each(data2, function (i, data2) {
                        $("#exp" + index).append(
                            `<option data-stock="${data2.quantity}" value="${
                                data2.exp
                            }">
                            ${data2.exp} (${data2.quantity.toFixed(
                                1
                            )}) <span class="text-muted">(${
                                data2.batch_no || ""
                            })</span>
                            </option>`
                        );
                        $("#batch_no" + index).val(data2.batch_no);
                    });
                },
            });

            getSaleTotalPrice();
            addSaleItem();
        },
        error: function (data) {
            $("#ppi" + index).attr("value", 0);
            $("#name" + index).attr("value", "Wrong barcode");
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
