<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\OrderedApps;

class Transport_orders extends Model
{
    use OrderedApps;

    protected $table = "transport_order";
    protected $fillable = ['company_branch_id','customer_id',
        'sub_service_id','item_transport','salesInvoice_cloud',
        'estimated_time_of_delivery','estimated_time_of_arrival',
        'time_zone','collie','by_users','harga','deliveryOrders_cloud',
        'actual_weight','chargeable_weight','notes','salesReceipt_cloud',
        'order_id','saved_origin_id','origin','origin_address',
        'origin_details','origin_contact','origin_phone','method_izzy',
        'saved_destination_id','destination','sync_DO',
        'destination_details','destination_address','total_cost',
        'destination_contact','destination_phone','status_order_id','purchase_order_customer',
        'pic_name_origin','pic_phone_origin','pic_phone_destination','pic_name_destination','volume','quantity',
        'salesQuotation_cloud','salesOrders_cloud','batch_item',
        'recovery_SQ','recovery_SO','recovery_DO','recovery_SI','recovery_ReceiptPayment','sync_accurate'
    ];

    protected $casts = ['batch_item'=> 'array'];

    public function customers(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function batchTransactionTransportIDX(){
        return $this->hasMany('App\Batchs_transaction_item_customer', 'transport_id');
    }

    public function itemtransports(){
        return $this->belongsTo('App\Item_transport','item_transport');
    }

    public function address(){
        return $this->hasMany('App\Address_book','customer_id');
    }

    public function company_branch(){
        return $this->belongsTo('App\Company_branchs','company_branch_id');
    }

    public function cek_status_transaction(){
        return $this->belongsTo('App\Transports_orders_statused','status_order_id');
    }

    public function job_transports(){
        return $this->hasMany('App\Job_transports','job_no');
    }

    public function job_transaction_details(){
        return $this->hasMany('App\Jobs_transaction_detail','id_shipment');
    }

    public function job_transaction_ones(){
        return $this->hasOne('App\Jobs_transaction_detail','id_shipment')->latest();
    }

    public function job_detail_shipement_status_id(){
        return $this->hasMany(Jobs_transaction_detail::class,'status_detail_shipment_id');
    }

    public function city_origin(){
        return $this->belongsTo('App\Address_book','saved_origin_id');
    }

    public function city_destination(){
        return $this->belongsTo('App\Address_book','saved_destination_id');
    }

    public function addressRelatsOrigins(){
        return $this->belongsTo('App\Address_book','saved_origin_id');
    }

    public function addressRelatsDestinations(){
        return $this->belongsTo('App\Address_book','saved_destination_id');
    }
    

}
