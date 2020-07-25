<div class="row hidden-print text-center">
    <div class="col-lg-12 col-sm-12">
    <a class="header-btn" href="/sales/addSale">
        <button type="button" class="btn btn-circle btn-info btn-lg">Add Sale </button></a>

        <a class="header-btn" href="/sale/seeSales"><button type="button" class="btn btn-circle btn-primary btn-lg">View Sales
       </button> </a>
       
         <a class="header-btn" href="/sale/search"><button type="button" class="btn btn-circle btn-warning btn-lg">Search Sales</button></a> 
         <a class="header-btn" href="{{ route('view-returned-sales') }}">
              <button type="button" class="btn btn-circle  btn-lg btn-danger">Returned sales</button>
        </a>
        <input type="hidden" id="type" value="sale">
    </div>
</div>

