<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = ['user_id', 'user_bv', 'order_no', 'qty', 'tot', 'pay_mode', 'buy_name', 'buy_contact', 'del_status', 'discount', 'paid'];

    public function saleshistory(){
        return $this->hasMany('App\SalesHistory');
    }

    public function salespayment(){
        return $this->hasMany('App\SalesPayment');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
