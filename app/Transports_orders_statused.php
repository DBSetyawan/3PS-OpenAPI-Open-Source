<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transports_orders_statused extends Model
{
    protected $table = "transport_order_status";
    protected $fillable = ["id","status_name"];
   
    public function transports_order(){
        return $this->hasMany('App\Transport_orders','id');
    }

    public function orderTransportHistori()
    {
        return $this->hasMany('App\Order_transport_history','status');
    }

}
