<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address_book extends Model
{
    protected $table = "address_book";
    
    protected $fillable = ['id','customer_id','city_id','name',
    'details','address','contact','phone','usersid',
    'pic_name_origin','pic_phone_origin','pic_name_destination','pic_phone_destination','users_company_id'];

    public function citys(){
        return $this->belongsTo('App\City','city_id');
    }

    public function customers(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function users(){
        return $this->belongsTo('App\User','usersid');
    }

    public function origins(){
        return $this->hasMany('App\Transport_orders','saved_origin_id');
    }

    public function destinations(){
        return $this->hasMany('App\Transport_orders','saved_destination_id');
    }
    
}
