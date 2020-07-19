<h5 class="card-text text-gray-dark">  
              <strong>$ {{$item->sale_price}}</strong> :&nbsp;&nbsp;&nbsp; نرخ/کارتۆن
      </h5>
      <h5 class="card-text text-gray-dark"> 
        <strong>IQD {{number_format(($item->sale_price/$item->items_per_box)*$rate->rate,0)}}</strong> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;نرخ/دانە
      </h5>
      <h5 class="card-text text-gray-dark">  
          <strong>IQD {{number_format(($item->sale_price_discount/$item->items_per_box)*$rate->rate,0)}}</strong> : نرخ/دانە/خەصم
        </h5>