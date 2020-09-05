<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industrys extends Model
{
    protected $table = "industrys";

    public function vendors(){
      return $this->hasMany('warehouse\Models\Vendors');
    }
}
