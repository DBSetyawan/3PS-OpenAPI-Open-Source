<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = ["id","province_id","name","citiesable_id","citiesable_type"];

    public function dis(){
      return $this->belongsTo('warehouse\Models\District','id');
    }

    public function province(){
        return $this->belongsTo('warehouse\Models\Province');
    }

    public function districts(){
        return $this->hasMany('warehouse\Models\District','id');
    }

    public function vendors(){
      return $this->hasMany('warehouse\Models\Vendors');
    }

    public function address_books_origin(){
      return $this->hasMany('warehouse\Models\Address_book','id');
    }

    public function vendor_items_transport(){
      return $this->hasMany('warehouse\Models\Vendor_item_transports','id');
    }

    public function city_jb(){
      return $this->hasMany('warehouse\Models\Job_transports','origin_id');
    }

    public function destination_jb(){
      return $this->hasMany('warehouse\Models\Job_transports','destination_id');
    }

    public function origin_tc(){
      return $this->hasMany('warehouse\Models\Transport_orders','saved_origin_id');
    }

    public function destination_tc(){
      return $this->hasMany('warehouse\Models\Transport_orders','saved_destination_id');
    }
  
}
