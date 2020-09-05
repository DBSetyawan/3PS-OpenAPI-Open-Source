<?php

namespace App\Models\Passport;

use Webpatser\Uuid\Uuid;
use Laravel\Passport\Client as OAuthClient; 

class Client extends OAuthClient
{ 

    public $incrementing = false; 

    public static function boot()
    { 
         static::creating(function ($model) {
            $model->uuid = Uuid::generate()->string; 
         }); 
    } 
}