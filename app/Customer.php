<?php

namespace App;

use Hash;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{

    use SoftDeletes, HasMultiAuthApiTokens;

    // protected $primaryKey = 'id';
    
    protected $guard = 'customer';

    protected $table = "customers";
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = ["oauth_access_account_id","customer_id","no_rek","bank_name","an_bank","company_id","personno","password",
    "term_of_payment","name", "industry_id","since","director","address","city_id","customerTaxType","ops_kodepos","provinceops",
    "phone","fax","email", "website", "tax_no", "tax_address","tax_city" , "tax_phone","itemID_accurate","PNGHN_alamat","PNGHN_city","PNGHN_province","PNGHN_country",
    "tax_fax" ,"status_id","created_at","updated_at","project_id","users_permissions"];

    public function industry(){
      return $this->belongsTo('App\Industrys');
    }

    public function MasterItemAccurate(){
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function status(){
        return $this->belongsTo('App\Vendor_status');
    }

    public function cstatusid(){
        return $this->belongsTo('App\Customer_status','status_id');
    }

    public function customer_pic(){
        return $this->hasMany('App\Customer_pics');
    }

    public function customer_pic_status(){
        return $this->belongsTo('App\Customer_pic_status');
    }

    public function warehouse_order(){
        return $this->hasMany('App\Warehouse_order','id');
    }

    public function transport_order(){
        return $this->hasMany('App\Transport_orders','id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function check_users_logged_in(){
        return $this->belongsTo('warehouse\User','users_permissions');
    }

    public function customer_item_transport(){
        return $this->hasMany(Item_transports::class,'id');
    }

    public function address_book_releated_this(){
        return $this->hasMany(Address_book::class,'id');
    }

}
