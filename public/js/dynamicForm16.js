          
         var i=0;
        function removeItem(id)
        {
           
            $('div').remove('#'+id);
            $('tr').remove('#'+id);
            getSaleTotalPrice();
            getPurchaseTotalPrice();
        }
       
        function addItem()
        {
          i=document.getElementById('howManyItems').value;
          i++;
          var item="<tr id='"+i+"'>";  
          
          item+="<td>";
          item+="<span class='badge badge-danger'>"+(i+1)+"</span>";
          item+="</td>";

          item+="<td>";
          item+="<select id='barcode"+i+"' name='barcode"+i+"' onchange='getPurchaseItemPrice(this.value,this.id)' onblur='getPurchaseItemPrice(this.value,this.id)' class='form-control select3'>";
          item+="</select>";            item+="</td>";

          item+="<td>";
          item+="<input type='number' step='0.01' onkeyup='getPurchaseTotalPrice();'  onblur='getPurchaseTotalPrice();' name='ppi"+i+"' id='ppi"+i+"' class='form-control '>";
          item+="</td>";

          item+="<td>";
          item+="<input type='number' step='250'  name='sppi"+i+"' id='sppi"+i+"' class='form-control '>";
          item+="</td>";

          item+="<td>";
          item+="<input type='number' step='1' onkeyup='getPurchaseTotalPrice();'  onblur='getPurchaseTotalPrice();' value='1' id='quantity"+i+"'  name='quantity"+i+"' class='form-control '>";
          item+="</td> ";


          item+="<td>";
          item+="<input type='number' step='1' onkeyup='getPurchaseTotalPrice();' value='0' required onblur='getPurchaseTotalPrice();' name='bonus"+i+"' id='bonus"+i+"' class='form-control '>";
          item+="</td>";

          item+="<td>";
          item+="<input type='date' name='exp"+i+"' id='exp"+i+"' class='form-control' required>";
          item+="</td> ";

           item+= "<td>"; 
          item+="<button class='btn btn-danger btn-circle btn3d' type='button'  onclick='removeItem("+i+")'>";
          item+="<i caption='delete' class='fa fa-minus-circle fa-1x'></i></button></td> ";
          item+="</tr>";
   
         $('.select3').select2();
          document.getElementById('howManyItems').value=i;
            $('#repeatedSale').append(item);
          $('.select3').select2({
             width: '100%',
			allowClear: true,
			multiple: true,
			maximumSelectionSize: 1,
        ajax: { 
          url: "/drugs/searchAjax",
          type: "post",
          dataType: 'json',
          data: function (params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });
          $('#barcode'+i).select2('open');

          
          $('#barcode'+i).select2('open');

          document.getElementById('howManyItems').value=i;

        }

        
        function addSaleItem()
        {
             i=document.getElementById('howManyItems').value;
             i++;
           var item="<tr id='"+i+"'>";   
          
          item+="<td>";
          item+="<span class='badge badge-danger'>"+(i+1)+"</span>";
          item+="</td>";

          item+="<td>";
          item+="<select id='barcode"+i+"' name='barcode"+i+"' onchange='getSaleItemPrice(this.value,this.id)' onblur='getSaleItemPrice(this.value,this.id)' class='form-control select3'>";
          item+="</select>";          
          item+="</td>";



          item+="<td>";
          item+="<input type='number' step='250' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' name='ppi"+i+"' id='ppi"+i+"' class='form-control '>";
          item+="</td>";

          item+="<td>";
          item+="<input type='number' step='1' onkeyup='getSaleTotalPrice();'  onblur='getSaleTotalPrice();' value='1' id='quantity"+i+"'  name='quantity"+i+"' class='form-control '>";
          item+="</td> ";


          item+="<td>";
          item+="<input type='number' step='0' id='singles"+i+"' name='singles"+i+"'  onkeyup='getSaleTotalPrice();' onblur='getSaleTotalPrice();' value='0'  class='form-control'>";
          item+="</td>";


          item+="<td>";
          item+="<span name='items_per_box"+i+"' id='items_per_box"+i+"' class='badge badge-primary'></span>";
          item+="</td>";

          item+="<td>";
          item+="<span class='badge badge-primary' id='subtotal"+i+"'></span>";
          item+="</td>";

           item+="<td>";
          item+="<select name='exp"+i+"' id='exp"+i+"' class='form-control '>";
          item+="<select></td> ";

           item+= "<td>"; 
          item+="<button class='btn btn-danger btn-circle btn3d' type='button'  onclick='removeItem("+i+")'>";
          item+="<i caption='delete' class='fa fa-minus-circle fa-1x'></i></button></td> ";
          item+="</tr>";
   

          $('.select3').select2();
          document.getElementById('howManyItems').value=i;
            $('#repeatedSale').append(item);
          $('.select3').select2({
             width: '100%',
            allowClear: true,
            multiple: true,
            maximumSelectionSize: 1,
        ajax: { 
          url: "/drugs/searchAjax",
          type: "post",
          dataType: 'json',
          data: function (params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });
          $('#barcode'+i).select2('open');

          // $(".table-fixed").freezeTable();

               
        }
    function getItemPrice(barcode,id)
    {
       var index=id.match(/\d+$/),number;
        index=index[0];
            $.ajax({
                       type: "GET",
                       dataType: "json",
                       url: "/purchases/ItemPrice",
                       data: "barcode=" + barcode,
                       success: function(data){
                         $("#name"+index).attr('value',data.name);
                        $("#ppi"+index).attr('value',data.price);
                       
                        //alert("price: " + data.price + "\nName: " + data.name);

                       getSaleTotalPrice();

                       },
                       error:function(){
                        $("#ppi"+index).attr('value',0);
                        $("#name"+index).attr('value','Wrong code');
                       }
                     });
         
    }
    function getPurchaseItemPrice(barcode,id)
    {

       var index=id.match(/\d+$/),number;
        index=index[0];
        $.ajax({
                       type: "GET",
                       dataType: "json",
                      url: "/purchases/ItemPurchasePrice",
                       data: "barcode=" + barcode,
                       success: function(data){
                         
                        $("#ppi"+index).attr('value',data.price);
                        $("#sppi"+index).attr('value',data.sale_price);
                        //$("#name"+index).attr('text',data.name);
                        //$("#ppi"+index).text(data.price);
                        $("#name"+index).text(data.name);
                        // $("#items_per_box"+index).val(data.items_per_box);
                        // $("#currency"+index).val(data.currency);
                        //alert("price: " + data.price + "\nName: " + data.name);
                       getPurchaseTotalPrice();
                       addItem(); 
                       },
                       error:function(){
                        $("#ppi"+index).attr('value',0);
                        $("#name"+index).attr('value','Wrong barcode');
                       }
                     });
                    
                     
    }

 function getSaleTotalPrice()
 {
  var total=0;
  var ppi=0;
  var quantity=0;
  var singles=0;
  var items_per_box=0;
  i=parseInt($('#howManyItems').val());
  for(j=0; j<=i; j++)
  {
     if(($("#ppi"+j).val()) && ($("#quantity"+j).val()))
     {
      ppi=$("#ppi"+j).val();
      quantity=$("#quantity"+j).val();
      singles=$("#singles"+j).val();
      items_per_box=$("#items_per_box"+j).text();
      subtotal=ppi*(+quantity+(+singles/items_per_box));
      if(subtotal%250!==0){
          subtotal=(250-(subtotal%250))+subtotal;
      }
      
      $(("#subtotal"+j)).text(subtotal);
      total=total+(+subtotal); 
     }
  }
  $('#total').attr('value',total);
}
  function getPurchaseTotalPrice()
 {
  var total=0;
  var ppi=0;
  var quantity=0;
  i=parseInt($('#howManyItems').val());
  for(j=0; j<=i; j++)
  {
     if(($("#ppi"+j).val()) && ($("#quantity"+j).val()))
     {
      ppi=$("#ppi"+j).val();
      quantity=$("#quantity"+j).val();
      total=total+(+ppi*+quantity); 
     }
  }
  console.log(total);
  $("#total").attr('value',(total).toFixed(2)); //only for purchase


}

  //  $("#saleForm").bind("keypress", function (e) {
  //    if (e.keyCode == 13) {
  //       //  addSaleItem();
  //       //  return false;
  //    }});


 function getSaleItemPrice(barcode,id)
    {
         var index=id.match(/\d+$/),number;
        index=index[0];
            $.ajax({
                       type: "GET",
                       dataType: "json",
                       url: "/purchases/ItemPrice",
                       data: "barcode=" + barcode,
                       success: function(data){
                        $("#ppi"+index).attr('value',data.price);
                        $("#name"+index).text(data.name);
                        $("#items_per_box"+index).text(data.items_per_box);
                        $.ajax({

                          type: "GET",
                          dataType: "json",
                          url: "/purchase/getExpiryDates",
                          data: "barcode=" + barcode,
                          success: function(data2)
                          {  
                            if (data2.length === 0)
                            {
                              alert('This item is not available in stock');
                              $("barcode" + index).select2("val", "");
                              return false;
                              }
                             $("#exp"+index).empty();
                             $.each(data2,function(i,data2){
                             $("#exp"+index).append('<option value="'+data2.exp+'">'+data2.exp+ '('+data2.quantity.toFixed(1)+')</option>');
                             
                             })
                          }
                        })

                       getSaleTotalPrice();
                       addSaleItem();


                       },
                       error:function(data){
                        $("#ppi"+index).attr('value',0);
                        $("#name"+index).attr('value','Wrong barcode');
                       }
                     });
                      

    }
    


function getCustomerName()
    {
        var id= $("#select2").val();
            $.ajax({
                       type: "GET",
                       dataType: "json",
                       url: "/customers/customerNameById",
                       data: "id=" + id,
                       success: function(data){
                        //alert(data.customerName);

                        $("#customerName").val(data.customerName);
                        $("#customerAddress").val(data.address);
                        $("#mobile").val(data.mobile);
                        $("#mobile2").val(data.mobile2);
                        $("#customerName").attr('readonly','readonly');
                        $("#mobile").attr('readonly','readonly');
                        $("#mobile2").attr('readonly','readonly');
                        $("#customerAddress").attr('readonly','readonly');
                        $("#debt").val(data.debt);
       
                        getSaleTotalPrice();
                       
                       },
                       error:function(){
                        $("#customerName").text('کۆدی کڕیارەکە هەڵەیە');
                        $("#customerName").val("");
                        $("#customerAddress").val("");
                        $("#mobile").val("");
                        $("#mobile2").val("");
                        $("#customerName").attr('readonly',false);
                        $("#mobile").attr('readonly',false);
                        $("#mobile2").attr('readonly',false);
                        $("#customerAddress").attr('readonly',false);
                       }
                     });
                     
    }


 function calculateTotalPaid(rate)
{
    if(rate==0)
    {
      rate=parseFloat($('#rate').val());
    }
    var dinars=parseFloat($('#dinars').val());
    var dollars=parseFloat($('#dollars').val());
    if(isNaN(dinars))
    {
      dinars=0;
    }
    if(isNaN(dollars))
    {
      dollars=0;
    }
    var totalPaid=((dinars/rate)+dollars).toFixed(2);
    $('#totalPaid').val(totalPaid);
}
function printExternal(url) {
    
    var printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}


function confirmDelete(id)
{
  $("#delete").attr('href', "/purchase/delete/"+id);
  $('#myModal').modal('show');
}

function confirmDeleteSale(id)
{
  $("#delete").attr('href', "/sale/delete/"+id);
  $('#myModal').modal('show');
}

