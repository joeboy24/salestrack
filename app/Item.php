<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //

    protected $fillable = ['item_no', 'user_id', 'name', 'desc', 'cat', 'brand', 'barcode', 'qty', 'price', 'cost_price', 'q1', 'q2', 'q3', 'b1', 'b2', 'b3'];



    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function itemimage(){
        return $this->belongsTo('App\ItemImage');
    }
}
